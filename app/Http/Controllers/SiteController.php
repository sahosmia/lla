<?php

namespace App\Http\Controllers;

use Modules\LaraPayease\Facades\PaymentDriver;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Nwidart\Modules\Facades\Module;
use App\Jobs\CompletePurchaseJob;
use App\Livewire\Actions\Logout;
use Spatie\Permission\Models\Role;
use App\Casts\BookingStatus;
use App\Services\GoogleCalender;
use App\Jobs\CompleteBookingJob;
use App\Services\BookingService;
use App\Services\WalletService;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SlotBooking;
use App\Facades\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\UserSubjectGroupSubject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    private $userService             = null;
    public  $googleSetToken          = null;
    private $googleCalenderService   = null;
    private $bookings                = null;
    public  $timezone;
    public  $currency_symbol;

    public function getGoogleToken(Request $request)
    {

        $this->googleCalenderService    = new GoogleCalender(Auth::user());
        $this->userService              = new UserService(Auth::user());
        $googleToken                    = $this->googleCalenderService->getAccessTokenInfo($request->get('code'));

        if (!empty($googleToken['error'])) {
            return redirect()->route('tutor.profile.account-settings')->with('error', __('passwords.failed_retrieve_Google_token'));
        }

        $primaryCalendar         = $this->googleCalenderService->getUserPrimaryCalendar($googleToken['access_token']);
        $primaryCalendar['data']['minutes'] = 30;
        $this->userService->setAccountSetting(['google_access_token', 'google_calendar_info'], [$googleToken, $primaryCalendar['data']]);
        return redirect()->route(Auth::user()->role . '.profile.account-settings')->with('success', __('passwords.connect_calender'));
    }

    public function completeBooking($id, BookingService $bookingService)
    {

        $booking = $bookingService->getBookingById($id);
        if (empty($booking)) {
            return redirect()->route('student.bookings')->with('error', __('general.booking_not_found'));
        }
        if ($booking->status != 'active' || Carbon::parse($booking->end_time)->isFuture()) {
            return redirect()->route('student.bookings')->with('error', __('calendar.unable_to_complete_booking'));
        }
        $bookingService->updateBooking($booking, ['status' => 'completed']);
        (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
        dispatch(new CompleteBookingJob($booking));
        return redirect()->route('student.bookings')->with('success', __('calendar.booking_completed'));
    }

    public function processPayment($gateway, Request $request)
    {

        $paymentData = session('payment_data');
        if (empty($paymentData)) {
            if ($request->source == 'api' && $request->upi) {
                return response()->json(['success' => false, 'message' => __('general.payment_cancelled_desc')], Response::HTTP_BAD_REQUEST);
            }
            return redirect()->route('checkout')->with('error', __('general.payment_cancelled_desc'));
        }

        $gatewayObj = getGatewayObject($gateway);
        if (!empty($gatewayObj)) {
            $response = $gatewayObj->chargeCustomer($paymentData);
            if (is_array($response) && array_key_exists('message', $response)) {
                if ($request->source == 'api' && $request->upi) {
                    return response()->json(['success' => false, 'message' => $response['message']], Response::HTTP_BAD_REQUEST);
                }
                return redirect()->route('checkout')->with('error', $response['message']);
            }
            return $response;
        }
    }

    public function payfastWebhook(Request $request)
    {
        header('HTTP/1.0 200 OK');
        flush();
        $gatewayObj = getGatewayObject('payfast');
        if (!empty($gatewayObj)) {
            $paymentData = $gatewayObj->paymentResponse($request->all());
            if (!empty($paymentData) && $paymentData['status'] == Response::HTTP_OK) {
                $this->paymentSuccess($request, webhook: true);
            }
        }
    }

    public function paymentSuccess(Request $request, $webhook = false)
    {
        $orderServices   = new OrderService();
        if ($request['payment_method'] == 'payfast' && empty($webhook)) {
            Cart::clear();
            session()->forget('order_id');
            $request->session()->forget('payment_data');
            if ($request->source == 'api' && $request->upi) {
                return response()->json(['success' => true, 'message' => __('general.payment_successful')], Response::HTTP_OK);
            }
            return redirect()->route('thank-you', ['id' => Order::latest()->first()?->id]);
        } else {
            $gatewayObj = getGatewayObject(empty($request['payment_method']) ? 'payfast' : $request['payment_method']);
            if (!empty($gatewayObj)) {
                $paymentData = $gatewayObj->paymentResponse($request->all());
                if (!empty($paymentData) && $paymentData['status'] == Response::HTTP_OK) {
                    $orderDetail   = $orderServices->getOrderDetail($paymentData['data']['order_id']);
                    $status = $orderServices->updateOrder($orderDetail, ['status' => 'complete', 'transaction_id' => $paymentData['data']['transaction_id']]);
                    if ($status) {
                        dispatch(new CompletePurchaseJob($orderDetail));
                        $request->session()->forget('payment_data');
                        if (Auth::guest() && !empty($orderDetail->orderBy)) {
                            Auth::login($orderDetail->orderBy);
                        }
                        Cart::clear();
                        session()->forget('order_id');

                        if ($request->source == 'api' && $request->upi) {
                            return response()->json(['success' => true, 'message' => __('general.payment_successful')], Response::HTTP_OK);
                        }
                        return redirect()->route('thank-you', ['id' => $paymentData['data']['order_id']]);
                    }
                } else {
                    if ($request->source == 'api' && $request->upi) {
                        return response()->json(['success' => true, 'message' => __('general.payment_cancelled')], Response::HTTP_BAD_REQUEST);
                    }
                    return redirect(route('checkout'))->with('error', __('general.payment_cancelled_desc'));
                }
            }
        }
    }

    public function removeCart(Request $request)
    {
        try {
            $bookingService = new BookingService();
            $itemType = !empty($request->cartable_type) ? $request->cartable_type : SlotBooking::class;

            if ($itemType == SlotBooking::class) {
                $bookingService->removeReservedBooking($request->cartable_id);
            }

            Cart::remove($request->cartable_id, $itemType);
            $orderServices = new OrderService();
            $orderServices->deleteOrderItem($request->cartable_id, $itemType);
            $cartData = Cart::content();
            $total = formatAmount(Cart::total(), true);
            $subTotal = formatAmount(Cart::subtotal(), true);
            return response()->json([
                'success'       => true,
                'cart_data'     => $cartData,
                'total'         => $total,
                'subTotal'      => $subTotal,
                'discount'      => formatAmount(Cart::discount(), true),
                'toggle_cart'   => 'open',
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing item from cart: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error removing item'], 500);
        }
    }

    public function logout(Logout $logout)
    {

        if (isActiveModule('ipmanager')) {
            $userLogService = app(\Modules\IPManager\Services\UserLogsService::class);
            $userLog = $userLogService->updateUserLog();
        }

        $logout();
        return redirect('/login');
    }

    public function preparePayment($id)
    {
        $orderDetail = (new OrderService())->getOrderDetailForPayment($id);
        if (empty($orderDetail)) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
        if ($orderDetail->status != 'pending') {
            return response()->json(['success' => false, 'message' => 'Order not in payable state'], 400);
        }
        $ipnUrl = PaymentDriver::getIpnUrl($orderDetail->payment_method);
        session(['payment_data' =>  [
            'amount'        => $orderDetail->amount - $orderDetail->used_wallet_balance,
            'title'         => 'Lernen Purchase',
            'description'   => 'Lernen Purchase Order Confirmation for reference #' . $orderDetail->id,
            'ipn_url'       => !empty($ipnUrl) ? route($ipnUrl, ['payment_method' => $orderDetail->payment_method, 'upi' => $orderDetail->unique_payment_id, 'source' => request()->get('source') ?? 'web']) : url('/'),
            'order_id'      => $orderDetail->id,
            'track'         => $orderDetail->unique_payment_id,
            'cancel_url'    => route('checkout', ['upi' => $orderDetail->unique_payment_id, 'source' => request()->get('source') ?? 'web']),
            'success_url'   => route('thank-you', ['id' => $orderDetail->id]),
            'email'         => $orderDetail->email,
            'name'          => $orderDetail->first_name,
            'payment_type'  => $orderDetail->payment_method,
        ]]);

        return redirect()->route('payment.process', ['gateway' => $orderDetail->payment_method]);
    }

    /**
     * Switch Language Via Session.
     * @param \Illuminate\Http\Request.
     */

    public function switchLang(Request $request)
    {
        $locale = $request->get('am-locale');
        $translatedLangs = array_keys(getTranslatedLanguages());
        if (in_array($locale, $translatedLangs)) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }

    /**
     * Switch currency Via Session.
     * @param \Illuminate\Http\Request.
     */

    public function switchCurrency(Request $request)
    {
        $currency = $request->get('am-currency');
        if (array_key_exists($currency, currencyList())) {
            session()->put('selected_currency', $currency);
        }
        return redirect()->back();
    }

    /**
     * Session Details
     * @param $sessionSlotId
     */
    public function sessionDetail($encryptedSessionSlotId)
    {

        try {
            $bookings       = null;
            $sessionSlotId  = decrypt($encryptedSessionSlotId);
            $sessionSlot    =  (new BookingService())->getSlotByDetail($sessionSlotId, true);

            if (auth()->check() && $sessionSlot?->end_time < now()) {
                $role = auth()->user()->role;
                $routes = [
                    'student' => 'student.bookings',
                    'tutor'   => 'tutor.bookings.upcoming-bookings'
                ];

                if (isset($routes[$role])) {
                    return redirect()->route($routes[$role]);
                }
            }

            if (auth()->check()) {
                $bookings = (new BookingService())->getBookingSlot($sessionSlotId, BookingStatus::$statuses['active']);
            }

            if (empty($sessionSlot)) {
                return redirect()->route('find-tutors')->with('error', __('calendar.no_session_found'));
            }

            return view('frontend.session-detail', compact('sessionSlot', 'bookings'));
        } catch (\Exception $e) {
            return redirect()->route('find-tutors')->with('error', __('calendar.no_session_found'));
        }
    }

    public function bookSession(Request $request)
    {

        $bookingService = new BookingService();
        $slot =  $bookingService->getSlotDetail($request->session_id);

        if (empty($slot)) {
            return response()->json(['error' => true, 'message' =>  __('tutor.slot_not_available')], 200);
        }

        $tutor = $slot->subjectGroupSubjects?->userSubjectGroup?->tutor;

        if (empty($tutor)) {
            return response()->json(['error' => true, 'message' =>  __('tutor.slot_not_available')], 200);
        }

        if (!isPaidSystem()) {

            (new BookingService())->createFreeBookingSlot($slot, $tutor);
            return response()->json(['success' => true, 'type'  => 'free'], 200);
        }

        $slotBookings = (new BookingService())->getBookingSlot($request->session_id);

        if ($slotBookings->isNotEmpty()) {
            return response()->json(['error' => true, 'message' => __('calendar.session_already_booked')], 200);
        }


        $currency               = setting('_general.currency');
        $currency_detail        = !empty($currency)  ? currencyList($currency) : array();

        if (!empty($currency_detail['symbol'])) {
            $this->currency_symbol = $currency_detail['symbol'];
        }

        if (!empty($slot)) {
            if ($slot->total_booked < $slot->spaces) {
                $bookedSlot = $bookingService->reservedBookingSlot($slot, $slot->subjectGroupSubjects?->userSubjectGroup?->tutorProfile);
                $data = [
                    'id' => $bookedSlot->id,
                    'slot_id' => $slot->id,
                    'tutor_id' => $bookedSlot->tutor_id,
                    'tutor_name' => $slot->subjectGroupSubjects?->userSubjectGroup?->tutorProfile?->full_name,
                    'session_time' => parseToUserTz($slot->start_time, $this->timezone)->format('h:i a') . ' - ' . parseToUserTz($slot->end_time, $this->timezone)->format('h:i a'),
                    'subject_group' => $slot->subjectGroupSubjects?->userSubjectGroup?->group?->name,
                    'subject' => $slot->subjectGroupSubjects?->subject?->name,
                    'image' => $slot->subjectGroupSubjects?->image,
                    'currency_symbol' => $this->currency_symbol,
                    'price' => number_format($slot->session_fee, 2),
                ];

                if (Module::has('subscriptions') && Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor') {
                    $data['allowed_for_subscriptions'] = $slot->meta_data['allowed_for_subscriptions'] ?? 0;
                }

                Cart::add(
                    cartableId: $data['id'],
                    cartableType: SlotBooking::class,
                    name: $data['subject'],
                    qty: 1,
                    price: $slot->session_fee,
                    options: $data
                );

                if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
                    $response = \Modules\KuponDeal\Facades\KuponDeal::applyCouponIfAvailable($slot->subjectGroupSubjects->id, UserSubjectGroupSubject::class);
                    if ($response['status'] == 'success') {
                        if ($response['status'] == 'success') {
                            $cartData = Cart::content();
                            return response()->json([
                                'success' => true,
                                'type'  => 'paid',
                                'cart_data' => $cartData,
                                'discount' => formatAmount(Cart::discount(), true),
                                'total' => formatAmount(Cart::total(), true),
                                'subTotal' => formatAmount(Cart::subtotal(), true),
                                'toggle_cart' => 'open'
                            ]);
                        }
                    }
                } else {
                    $cartData = Cart::content();
                    return response()->json([
                        'success' => true,
                        'cart_data' => $cartData,
                        'total' => formatAmount(Cart::total(), true),
                        'subTotal' => formatAmount(Cart::subtotal(), true),
                        'toggle_cart' => 'open'
                    ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => __('tutor.not_available_slot')], 200);
            }
        }
    }
    public function downloadPDF($id)
    {
        try {

            $logo               = setting('_general.invoice_logo');
            $company_logo       = !empty($logo[0]['path']) ? Storage::disk(getStorageDisk())->path($logo[0]['path']) : asset('demo-content/logo-default.svg');

            $company_name       = setting('_general.company_name');
            $company_email      = setting('_general.company_email');
            $company_address    = setting('_general.company_address');
            $invoice            = (new OrderService())->getOrdeWrWithItem($id, ['items', 'userProfile', 'countryDetails']);

            if (empty($invoice)) {
                return response()->json(['error' => __('general.no_orders_received')], 400);
            }
            return Pdf::loadView('pdf.invoice-list', compact('invoice', 'company_logo', 'company_name', 'company_email', 'company_address'))->stream();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function switchRole(Request $request)
    {
        $user = Auth::user();
        $userRole = getUserRole()['roleName'];
        $newRole = $userRole === 'tutor' ? 'student' : 'tutor';
        $newRoleObj = Role::where('name', $newRole)->first();

        if (!$newRoleObj) {
            return response()->json([
                'success' => false,
                'message' => "Role '$newRole' not found."
            ], 404);
        }

        if (!$user->hasRole($newRole)) {
            $user->assignRole($newRole);
        }

        // Store default role if not already stored
        if (!Session::has('default_role_id' . $user->id)) {
            Session::put('default_role_id' . $user->id, $user->roles->first()->id);
        }

        // Store active role
        Session::put('active_role_id' . $user->id, $newRoleObj->id);

        return response()->json([
            'success' => true,
            'newRole' => $newRole,
        ]);
    }
}
