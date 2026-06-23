<?php

namespace Modules\LaraPayease\Drivers;

use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use Modules\LaraPayease\BasePaymentDriver;
use Modules\LaraPayease\Traits\Currency;
use Symfony\Component\HttpFoundation\Response;

class SslCommerz extends BasePaymentDriver
{
    use Currency;

    public function driverName(): string
    {
        return 'sslcommerz';
    }

    public function chargeCustomer(array $params)
    {
        $keys = $this->getKeys();
        if (empty($keys['store_id']) || empty($keys['store_password'])) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Missing SSLCommerz store credentials')];
        }

        $order = Order::find($params['order_id'] ?? null);
        if (empty($order)) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Order not found')];
        }

        $this->configureSslCommerz($keys);

        $amount = $this->chargeableAmount($params['amount']);
        $currency = strtoupper($this->getCurrency());
        $tranId = $order->unique_payment_id ?? (string) $order->id;

        $postData = [
            'total_amount' => $amount,
            'currency' => $currency,
            'tran_id' => $tranId,
            'product_category' => 'Education',
            'product_name' => $params['title'] ?? 'Purchase',
            'product_profile' => 'non-physical-goods',
            'cus_name' => trim(($params['name'] ?? $order->first_name) . ' ' . ($order->last_name ?? '')),
            'cus_email' => $params['email'] ?? $order->email,
            'cus_add1' => $order->city ?: 'Dhaka',
            'cus_city' => $order->city ?: 'Dhaka',
            'cus_state' => $order->state ?? '',
            'cus_postcode' => $order->postal_code ?: '1000',
            'cus_country' => 'Bangladesh',
            'cus_phone' => $this->formatPhone($order->phone),
            'shipping_method' => 'NO',
            'ship_name' => $order->first_name ?: 'Customer',
            'ship_add1' => $order->city ?: 'Dhaka',
            'ship_city' => $order->city ?: 'Dhaka',
            'ship_postcode' => $order->postal_code ?: '1000',
            'ship_country' => 'Bangladesh',
            'success_url' => $params['ipn_url'] ?? route('get.success', ['payment_method' => 'sslcommerz']),
            'fail_url' => route('sslcommerz.fail', ['payment_method' => 'sslcommerz']),
            'cancel_url' => $params['cancel_url'] ?? route('sslcommerz.cancel'),
            'ipn_url' => route('sslcommerz.ipn'),
            'value_a' => (string) $order->id,
        ];

        $sslc = new SslCommerzNotification();
        $paymentOptions = $sslc->makePayment($postData, 'hosted');

        if (!is_array($paymentOptions) && is_string($paymentOptions)) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => $paymentOptions];
        }

        return null;
    }

    public function paymentResponse(array $params = [])
    {
        $tranId = $params['tran_id'] ?? '';
        $amount = $params['amount'] ?? 0;
        $currency = $params['currency'] ?? 'BDT';

        if (empty($tranId)) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Missing transaction ID')];
        }

        $order = Order::where('unique_payment_id', $tranId)->first();
        if (empty($order) && !empty($params['value_a'])) {
            $order = Order::find($params['value_a']);
        }
        if (empty($order)) {
            $orderId = session('payment_data.order_id') ?? null;
            $order = $orderId ? Order::find($orderId) : null;
        }

        if (empty($order)) {
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('Order not found')];
        }

        if ($order->status === 'complete') {
            return [
                'status' => Response::HTTP_OK,
                'data' => [
                    'transaction_id' => $order->transaction_id ?? $tranId,
                    'order_id' => $order->id,
                ],
            ];
        }

        $this->configureSslCommerz($this->getKeys());

        $sslc = new SslCommerzNotification();
        $validation = $sslc->orderValidate($params, $tranId, $amount, $currency);

        if ($validation === true) {
            $transactionId = $params['bank_tran_id'] ?? $params['val_id'] ?? $tranId;

            return [
                'status' => Response::HTTP_OK,
                'data' => [
                    'transaction_id' => $transactionId,
                    'order_id' => $order->id,
                ],
            ];
        }

        return ['status' => Response::HTTP_BAD_REQUEST, 'order_id' => $order->id];
    }

    private function configureSslCommerz(array $keys): void
    {
        $isTest = $this->getMode() === 'test';

        config([
            'sslcommerz.apiCredentials.store_id' => $keys['store_id'],
            'sslcommerz.apiCredentials.store_password' => $keys['store_password'],
            'sslcommerz.apiDomain' => $isTest ? 'https://sandbox.sslcommerz.com' : 'https://securepay.sslcommerz.com',
            'sslcommerz.connect_from_localhost' => $isTest || filter_var(env('IS_LOCALHOST', false), FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    private function formatPhone(?string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone ?? '');

        if (empty($phone)) {
            return '01700000000';
        }

        if (str_starts_with($phone, '880')) {
            return $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '88' . $phone;
        }

        return '880' . $phone;
    }
}
