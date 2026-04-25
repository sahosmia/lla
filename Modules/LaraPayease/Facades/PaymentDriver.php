<?php

namespace Modules\LaraPayease\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static \Modules\LaraPayease\Drivers\Stripe stripe()
 * @method static \Modules\LaraPayease\Drivers\RazorPay razorpay()
 * @method static \Modules\LaraPayease\Drivers\Flutterwave flutterwave()
 * @method static \Modules\LaraPayease\Drivers\Paystack paystack()
 * @method static \Modules\LaraPayease\Drivers\Paypal paypal()
 * @method static \Modules\LaraPayease\Drivers\PayFast payfast()
 * @method static \Modules\LaraPayease\Drivers\Paytm paytm()
 * @method static array supportedCurrencies()
 * @method static array supportedGateways()
 * @method static string getIpnUrl()
 */

class PaymentDriver extends Facade {

    protected static function getFacadeAccessor(): string
    {
        return 'larapayease';
    }
}
