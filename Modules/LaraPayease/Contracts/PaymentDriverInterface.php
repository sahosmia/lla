<?php

namespace Modules\LaraPayease\Contracts;

interface PaymentDriverInterface
{
    public function driverName();
    public function paymentResponse(array $params);
    public function chargeCustomer(array $params);
}
