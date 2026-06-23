<?php

namespace Modules\LaraPayease\Traits;

use Modules\LaraPayease\Utils\CurrencyUtil;

trait Currency {

    /**
     * Convert the amount to the appropriate unit for the currency.
     *
     * @param float $amount
     * @return int
     */
    public function chargeableAmount($amount)
    {
        $currency       = $this->getCurrency();
        $driver         = $this->driverName();
        $exchangeRate   = $this->getExchangeRate();


        if (!empty($exchangeRate)) {
            $amount = $amount * $exchangeRate;
        }

        if (in_array(strtoupper($currency), CurrencyUtil::$zeroDecimalCurrencies)) {
            return (int) $amount;
        }

        if (in_array($driver, CurrencyUtil::$subUnitsPaymentGateways)) {
            return (int)($amount * 100);
        }

        return number_format($amount, 2, '.', '');

    }

}
