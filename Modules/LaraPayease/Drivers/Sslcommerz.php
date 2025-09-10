<?php

namespace Modules\LaraPayease\Drivers;

use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Log;
use Modules\LaraPayease\BasePaymentDriver;
use Modules\LaraPayease\Traits\Currency;
use Symfony\Component\HttpFoundation\Response;

class Sslcommerz extends BasePaymentDriver
{
    use Currency;

    public function chargeCustomer(array $params)
    {
        if (empty($this->getKeys()['sslcz_store_id']) || empty($this->getKeys()['sslcz_store_password'])) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Missing Sslcommerz key or secret')];
        }

        $post_data = [];
        $post_data['total_amount'] = $params['amount'];
        $post_data['currency'] = $this->getCurrency();
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $params['name'];
        $post_data['cus_email'] = $params['email'];
        $post_data['cus_add1'] = $params['address'];
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $params['phone'];
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = $params['title'];
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $params['order_id'];
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function driverName(): string
    {
        return 'sslcommerz';
    }

    public function paymentResponse(array $params = [])
    {
        $sslc = new SslCommerzNotification();
        $validation = $sslc->orderValidate($params, $params['tran_id'], $params['amount'], $params['currency']);

        if ($validation) {
            return [
                'status' => Response::HTTP_OK,
                'data'   => [
                    'transaction_id' => $params['tran_id'],
                    'order_id' => $params['value_a']
                ]
            ];
        }
        return ['status' => Response::HTTP_BAD_REQUEST,'order_id' => $params['value_a']];
    }

    public function prepareCharge(array $params)
    {
        StripeSdk::setApiKey(base64_decode($params['sslcommerz_secret']));

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

        session()->put('sslcommerz_session_id', $session->id);
        session()->put('order_id', $params['order_id']);

        return ['id' => $session->id];
    }
}
