<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Payout\PayoutRequest;
use App\Http\Requests\Tutor\Payout\PaymentRequest;
use App\Http\Resources\PayoutCollection;
use App\Http\Resources\PayoutResource;
use App\Services\PayoutService;
use App\Services\WalletService;
use App\Http\Requests\Tutor\Withdrawal\WithdrawalRequest;
use App\Traits\ApiResponser;
use App\Jobs\SendNotificationJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PayoutController extends Controller
{
    use ApiResponser;

    public function getPayoutHistory(Request $request,$id)
    {
        if($id != Auth::user()->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_UNAUTHORIZED);
        }
        $payoutService      = new PayoutService();
        $withdrawalDetails  = $payoutService->getWithdrawalDetail(Auth::user()->id, $request->status);
        return $this->success(data: new PayoutCollection($withdrawalDetails));
    }

    public function getEarning(Request $request,$id)
    {
        if($id != Auth::user()->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_UNAUTHORIZED);
        }

        $payoutService          = new PayoutService();
        $walletService          = new WalletService();
        $earnedAmount           = $walletService->getEarnedIncome(Auth::user()->id);
        $walletBalance          = $walletService->getWalletAmount(Auth::user()->id);
        $pendingBalance         = $walletService->getPendingAvailableFunds(Auth::user()->id);
        $withdrawalBalance      = $payoutService->geWithdrawalBalance(Auth::user()->id)->toArray();

        $data = [
            'earned_amount'         => formatAmount($earnedAmount),
            'wallet_balance'        => formatAmount($walletBalance),
            'pending_withdrawals'   => formatAmount($withdrawalBalance['pending_withdrawals']),
            'completed_withdrawals' => formatAmount($withdrawalBalance['completed_withdrawals']),
            'pending_balance'       => formatAmount($pendingBalance),
        ];

        return $this->success(message: __('api.successfully_get_earning'),data: $data);
    }

    public function getPayoutStatus(Request $request)
    {
        $payoutService     = new PayoutService();
        $payoutStatus      = $payoutService->getPayoutStatus(Auth::user()->id);
        $withdrawalTypes   = $payoutService->getWithdrawalTypes(Auth::user()->id);
        $data = $payoutStatus;
        $data['balance']['payoneer']    = $withdrawalTypes['payoneer']?->total_amount ?? 0;
        $data['balance']['paypal']      = $withdrawalTypes['paypal']?->total_amount ?? 0;
        $data['balance']['bank']        = $withdrawalTypes['bank']?->total_amount ?? 0;

        if(!$payoutStatus){
            $data['payouts_status'] = 'Not exist';  
        }
        return $this->success(message: __('api.successfully_get_payout_status'),data: $data);
    }

    public function addPayoutMethod(PayoutRequest $request)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $payoutService     = new PayoutService();

        $payout = [
            'user_id'           => Auth::user()->id,
            'status'            => 'active',
            'payout_method'     => $request->current_method,
            'deleted_at'        => null,
            'payout_details'    => $request->current_method != 'bank' ?  [['email'=> $request->email]] : [
                'title'                 => $request->title,
                'account_number'        => $request->accountNumber,
                'bank_name'             => $request->bankName,
                'bank_routing_number'   => $request->bankRoutingNumber,
                'bank_iban'             => $request->bankIban,
                'bank_btc'              => $request->bankBtc,
            ],

        ];

        $payout = $payoutService->addPayoutDetail(Auth::user()->id,$request->current_method,$payout);
        return $this->success(message: __('api.successfully_add_payout_method'),data: new PayoutResource($payout));
    }

    public function updateStatus(PaymentRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $payoutService     = new PayoutService();
        $payoutService->updatePayoutStatus(Auth::user()->id,$request->current_method);
        $payoutStatus      = $payoutService->getPayoutStatus(Auth::user()->id);
        $data = $payoutStatus;
        if(!$payoutStatus){
            $data['payouts_status'] = 'Not exist';
        }
        return $this->success(message: __('api.successfully_update'),data: $data);
    }

    public function removePayoutMethod(PaymentRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $payoutService      = new PayoutService();
        $status             = $payoutService->deletePayout(Auth::user()->id,$request->current_method);
        if(!$status){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }
        return $this->success(message: __('api.deleted_successfully'));
    }

    public function getEarningDetail(Request $request)
    {
        $walletService        = new WalletService();
        $selectedDate         = now(getUserTimezone());
        $data                 = $walletService->getUserEarnings(Auth::user()->id, $selectedDate);
        return $this->success(message: __('api.successfully_get_earning_detail'),data: $data);
    }

    public function userWithdrawal(WithdrawalRequest $request)
    {
        $payoutService     = new PayoutService();
        $walletService     = new WalletService();
        $payoutMethod      = $payoutService->activePayoutMethod(Auth::user()->id);
        if(!$payoutMethod){
            return $this->error(data: null,message: __('api.not_found_payout_method'),code: Response::HTTP_NOT_FOUND);
        }
        $withdrawalBalance    = $payoutService->updateWithDrawals(Auth::user()->id,$request->amount);
        if($withdrawalBalance){
           $walletService->deductFunds(Auth::user()->id, $request->amount, 'deduct_withdrawn');
           dispatch(new SendNotificationJob('withdrawWalletAmountRequest',User::admin(), ['name' => Auth::user()->profile->full_name, 'amount' => $request->amount, ]));
        }
        return $this->success(message: __('api.successfully_user_withdrawal'));
    }
}




