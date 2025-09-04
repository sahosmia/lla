<?php

namespace Modules\LaraPayease\Utils;

class CurrencyUtil
{
    public static $zeroDecimalCurrencies = [
        'BIF','CLP','DJF','GNF','JPY', 'KMF','KRW', 'MGA', 'PYG','RWF','UGX','VND','VUV', 'XAF','XOF', 'XPF'
    ];

    public static $supportedCurrencies = [
        'stripe'    => [ 'USD', 'EUR', 'INR', 'IDR', 'AUD', 'SGD', 'JPY', 'GBP', 'MYR', 'PHP', 'THB', 'KRW', 'NGN', 'GHS', 'BRL', 'BIF', 'CAD', 'CDF', 'CVE', 'GHP', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BMD', 'BND', 'BOB', 'BSD', 'BWP', 'BZD', 'CHF', 'CNY', 'CLP', 'COP', 'CRC', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'FJD', 'FKP', 'GEL', 'GIP', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'ILS', 'ISK', 'JMD', 'KGS', 'KHR', 'KMF', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LSL', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MXN', 'NAD', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'SAR', 'SBD', 'SCR', 'SEK', 'SHP', 'SOS', 'SRD', 'SZL', 'TJS', 'TRY', 'TTD', 'TWD', 'UAH', 'UYU', 'UZS', 'VND', 'VUV', 'WST', 'XCD', 'XPF', 'YER', 'ZAR' ],
    ];

    public static $subUnitsPaymentGateways = ['stripe', 'razorpay', 'paystack'];

     /**
     * Check if a currency is supported by a given payment driver.
     *
     * @param string $driver
     * @param string $currency
     * @return bool
     */
    public static function isCurrencySupported($driver, $currency)
    {
        return in_array(strtoupper($currency), self::$supportedCurrencies[strtolower($driver)] ?? []);
    }
}
