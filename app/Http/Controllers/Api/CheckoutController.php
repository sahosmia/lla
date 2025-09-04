<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SlotBooking;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\CompletePurchaseJob;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;
use App\Services\WalletService;
use App\Http\Requests\Student\Order\OrderRequest;
use App\Traits\ApiResponser;

class CheckoutController extends Controller
{
    use ApiResponser;
    public function addCheckoutDetails(OrderRequest $request) {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $orderService   = new OrderService();
        $walletService  = new WalletService();
        $walletBalance  = $walletService->getWalletAmount(Auth::user()->id);
        
        if($request->useWalletBalance && empty($walletBalance)){
            return $this->error(data: null,message: __('api.wallet_balance_empty'),code: Response::HTTP_BAD_REQUEST);
        }
        
        if($request->useWalletBalance && empty($request->amount)){
            return $this->error(data: null,message: __('api.amount_is_required'),code: Response::HTTP_BAD_REQUEST);
        }

        $content   = Cart::content(); 

        if ($content->count() == 0) {
            return $this->error(data: null,message: __('api.cart_is_empty'),code: Response::HTTP_BAD_REQUEST);
        }

        $uniquePaymentId = Str::uuid();

        $billingDetail = [
            'user_id'                   => Auth::user()->id,
            'first_name'                => $request?->firstName,
            'unique_payment_id'         => $uniquePaymentId,
            'amount'                    => $request?->amount,
            'currency'                  => setting('_general.currency') ?? '',
            'used_wallet_amt'           => $request?->useWalletBalance ? $walletBalance : 0,
            'last_name'                 => $request?->lastName,
            'company'                   => $request?->company,
            'email'                     => $request?->email,
            'phone'                     => $request?->phone,
            'country'                   => $request?->country,
            'state'                     => $request?->state ,
            'city'                      => $request?->city  ,
            'postal_code'               => $request?->zipcode,
            'payment_method'            => $request?->paymentMethod,
            'description'               => $request?->description,
        ];
      
        $orderDetail = $orderService->createOrder($billingDetail);

        $orderItems = [];

        foreach ($content as $item) {
            $orderItems[] = [
                'order_id'       => $orderDetail->id,
                'title'          => $item['name'],
                'quantity'       => $item['qty'],
                'options'        => $item['options'],
                'price'          => $item['price'],
                'total'          => (float)$item['qty'] * (float)$item['price'],
                'orderable_id'   => $item['cartable_id'],
                'orderable_type' => $item['cartable_type'],
            ];
        }
        
        $orderItems = $orderService->storeOrderItems($orderDetail->id,$orderItems);

        if ($request->useWalletBalance ) {
            if($walletBalance >= $request->amount){
                $walletService->deductFunds(Auth::user()->id, $request->amount, 'deduct_booking', $orderDetail->id);
            } else{
                $walletService->deductFunds(Auth::user()->id, $walletBalance, 'deduct_booking', $orderDetail->id);
            }
        }
        
        if($request->useWalletBalance && ($walletBalance >= $request->amount) ){
           $orderDetail = $orderService->updateOrder($orderDetail,['status'=>'complete']);
           dispatch(new CompletePurchaseJob($orderDetail));
           Cart::clear();
            return $this->success(data: ['payment_status' => 'completed'], message: __('api.checkout_details_added_successfully'));
        } else{
            $url  = route('pay',['id' => $uniquePaymentId, 'source' => 'api']);
            return $this->success(data: ['payment_status' => 'pending', 'payment_url' => $url, 'order_id' => $orderDetail->id], message: __('api.checkout_details_added_successfully'));
        }
    }
}
