<?php

namespace Modules\LaraPayease\Http\Controllers;

use Modules\LaraPayease\Facades\PaymentDriver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripePaymentController extends Controller{

    public function prepareCharge(Request $request){
        try{
            $stripe_session = PaymentDriver::stripe()->prepareCharge([
                'amount' => $request->amount,
                'charge_amount' => $request->charge_amount,
                'title' => $request->title,
                'description' => $request->description,
                'ipn_url' => $request->ipn_url,
                'order_id' => $request->order_id,
                'track' => $request->track,
                'cancel_url' => $request->cancel_url,
                'success_url' => $request->success_url,
                'email' => $request->email,
                'name' => $request->name,
                'payment_type' => $request->payment_type,
                'stripe_secret' => $request->stripe_secret,
                'currency' => $request->currency,
            ]);
            return response()->json(['id' => $stripe_session['id']]);
        }catch(\Exception $e){
            return response()->json(['msg' => $e->getMessage(),'type' => 'danger']);
        }
    }

}
