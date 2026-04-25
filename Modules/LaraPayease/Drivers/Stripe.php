<?php

namespace Modules\LaraPayease\Drivers;

use Modules\LaraPayease\BasePaymentDriver;
use Modules\LaraPayease\Traits\Currency;
use Stripe\Checkout\Session;
use Stripe\Stripe as StripeSdk;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Response;

class Stripe extends BasePaymentDriver
{
    use Currency;

    public function chargeCustomer(array $params){
        if(empty($this->getKeys()['stripe_key']) || empty($this->getKeys()['stripe_secret'])){
            return ['status' => Response::HTTP_BAD_REQUEST,'message' => __('Missing Stripe key or secret')];
        }
        return view('larapayease::stripe', ['stripe_data' => array_merge($params,[
            'stripe_key' => $this->getKeys()['stripe_key'],
            'currency' => $this->getCurrency(),
            'stripe_secret' => base64_encode($this->getKeys()['stripe_secret']),
            'charge_amount' => $this->chargeableAmount($params['amount']),
        ])]);
    }

    public function driverName() : string{
        return 'stripe';
    }

    public function paymentResponse(array $params = [])
    {
        $stripeSessionId = session()->get('stripe_session_id');
        session()->forget('stripe_session_id');
        $orderId = session()->get('order_id');
        session()->forget('order_id');

        if (empty($stripeSessionId)) {
            return ['status' => Response::HTTP_BAD_REQUEST,'message' => __('Missing Session Id')];
        }

        $stripe = new StripeClient($this->getKeys()['stripe_secret']);
        $response = $stripe->checkout->sessions->retrieve($stripeSessionId, []);
        $paymentIntent = $response['payment_intent'] ?? '';
        $paymentStatus = $response['payment_status'] ?? '';

        $capture = $stripe->paymentIntents->retrieve($paymentIntent);
        if (!empty($paymentStatus) && $paymentStatus === 'paid' && $capture->status === 'succeeded') {
            $transaction_id = $paymentIntent;
            if (!empty($transaction_id)) {
                return [
                    'status' => Response::HTTP_OK,
                    'data'   => [
                        'transaction_id' => $transaction_id,
                        'order_id' => $orderId
                    ]
                ];
            }
        }

        return ['status' => Response::HTTP_BAD_REQUEST,'order_id' => $orderId];
    }

    public function prepareCharge(array $params){
        StripeSdk::setApiKey(base64_decode($params['stripe_secret']));

        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $params['currency'],
                    'product_data' => [
                        'name' => $params['title'],
                        'description' => $params['description']
                    ],
                    'unit_amount' => $params['charge_amount'],
                ],
                'quantity' => 1
            ]],
            'mode' => 'payment',
            'customer_email' => $params['email'],
            'success_url' => $params['ipn_url'],
            'cancel_url' => $params['cancel_url'],
        ]);

        session()->put('stripe_session_id', $session->id);
        session()->put('order_id', $params['order_id']);

        return ['id' => $session->id];
    }
}
