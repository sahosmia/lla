<?php

namespace Modules\LaraPayease\Drivers;

use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Log;
use Modules\LaraPayease\BasePaymentDriver;
use Modules\LaraPayease\Traits\Currency;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;
use App\Jobs\CompletePurchaseJob;
use App\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class Sslcommerz extends BasePaymentDriver
{
    use Currency;

    public function chargeCustomer(array $params)
    {
        if (empty($this->getKeys()['sslcz_store_id']) || empty($this->getKeys()['sslcz_store_password'])) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Missing Sslcommerz key or secret')];
        }

        $post_data = $this->prepareCharge($params);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (is_array($payment_options) && array_key_exists('GatewayPageURL', $payment_options)) {
            return redirect($payment_options['GatewayPageURL']);
        }

        return ['status' => Response::HTTP_BAD_REQUEST, 'message' => $payment_options];
    }

    public function driverName(): string
    {
        return 'sslcommerz';
    }

    public function paymentResponse(array $params = [])
    {
        $tran_id = $params['tran_id'] ?? null;
        $amount = $params['amount'] ?? null;
        $currency = $params['currency'] ?? null;

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = Order::where('transaction_id', $tran_id)->first();

        if ($order_details->status == 'pending') {
            $validation = $sslc->orderValidate($params, $tran_id, $amount, $currency);

            if ($validation) {
                $order = Order::where('transaction_id', $tran_id)->first();
                $order->update(['status' => 'completed']);
                dispatch(new CompletePurchaseJob($order));
                Cart::clear();
                session()->forget('order_id');
                if (Auth::guest() && !empty($order->orderBy)) {
                    Auth::login($order->orderBy);
                }
                return [
                    'status' => Response::HTTP_OK,
                    'data'   => [
                        'transaction_id' => $tran_id,
                        'order_id' => $order->id
                    ]
                ];
            }
        } else if ($order_details->status == 'processing' || $order_details->status == 'completed') {
            $order = Order::where('transaction_id', $tran_id)->first();
            return [
                'status' => Response::HTTP_OK,
                'data'   => [
                    'transaction_id' => $tran_id,
                    'order_id' => $order->id
                ]
            ];
        } else {
            return ['status' => Response::HTTP_BAD_REQUEST,'order_id' => $order_details->id];
        }
    }

    public function prepareCharge(array $params)
    {
        $post_data = [];
        $post_data['total_amount'] = $params['amount'];
        $post_data['currency'] = $this->getCurrency();
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $params['name'];
        $post_data['cus_email'] = $params['email'];
        $post_data['cus_add1'] = $params['address'] ?? 'N/A';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = $params['city'] ?? '';
        $post_data['cus_state'] = $params['state'] ?? '';
        $post_data['cus_postcode'] = $params['zipcode'] ?? '';
        $post_data['cus_country'] = $params['country'] ?? '';
        $post_data['cus_phone'] = $params['phone'] ?? 'N/A';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $params['name'];
        $post_data['ship_add1'] = $params['address'] ?? 'N/A';
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = $params['city'] ?? '';
        $post_data['ship_state'] = $params['state'] ?? '';
        $post_data['ship_postcode'] = $params['zipcode'] ?? '';
        $post_data['ship_country'] = $params['country'] ?? '';
        $post_data['ship_phone'] = $params['phone'] ?? 'N/A';

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = $params['title'];
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $params['order_id'];
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        return $post_data;
    }
}
