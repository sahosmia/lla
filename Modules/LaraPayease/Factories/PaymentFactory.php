<?php

namespace Modules\LaraPayease\Factories;
use Modules\LaraPayease\Drivers\Sslcommerz;
use Modules\LaraPayease\Utils\CurrencyUtil;

class PaymentFactory {

    /**
     * @return \Modules\LaraPayease\Drivers\Sslcommerz
     */
    public function sslcommerz(): Sslcommerz
    {
        return new Sslcommerz();
    }

     /**
      * @return \Modules\LaraPayease\Utils\CurrencyUtil\supportedCurrencies
      */

     public function supportedCurrencies(): array{
        return CurrencyUtil::$supportedCurrencies;
     }

      /**
       * @return array $supportedGateways
       */
     public function supportedGateways() : array{
        return [
          'sslcommerz' => [
                'keys' => [
                    'sslcz_store_id' => env('SSLCZ_STORE_ID'),
                    'sslcz_store_password' => env('SSLCZ_STORE_PASSWORD'),
                ],
                'status' => 'off',
                'currency' => 'BDT',
                'exchange_rate' => '',
                'ipn_url_type' => 'post.ipn'
            ],
        ];
     }

      /**
       * @return string $getIpnUrl
       */
     public function getIpnUrl($method): string {
          $gateWays = $this->supportedGateways();
          if(!empty($gateWays[$method]['ipn_url_type'])) {
              return $gateWays[$method]['ipn_url_type'];
          }
          return '';
     }
}
