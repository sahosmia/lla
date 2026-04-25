<?php

namespace Modules\LaraPayease;

use Modules\LaraPayease\Contracts\PaymentDriverInterface;

abstract class BasePaymentDriver implements PaymentDriverInterface {

    protected array $keys;
    protected string $paymentMode;
    protected string $currency;
    protected string $exhangeRate;

    public function setKeys(array $keys)
    {
        $this->keys = $keys;
    }

    public function getKeys():array
    {
        return $this->keys;
    }

    public function setMode(string $mode)
    {
        $this->paymentMode = $mode;
    }

    public function getMode(): string
    {
        return $this->paymentMode;
    }

    public function setExchangeRate($rate = '')
    {
        $this->exhangeRate = $rate;
    }

    public function getExchangeRate(): mixed
    {
        return $this->exhangeRate;
    }

    public function setCurrency($currency = 'USD')
    {
        $this->currency = $currency;
    }

    public function getCurrency(): string {
        return $this->currency;
    }
}
