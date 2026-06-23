<?php

// SSLCommerz configuration

$apiDomain = filter_var(env('SSLCZ_TESTMODE', false), FILTER_VALIDATE_BOOLEAN)
    ? 'https://sandbox.sslcommerz.com'
    : 'https://securepay.sslcommerz.com';

return [
	'apiCredentials' => [
		'store_id' => env('SSLCZ_STORE_ID'),
		'store_password' => env('SSLCZ_STORE_PASSWORD'),
	],
	'apiUrl' => [
		'make_payment' => '/gwprocess/v4/api.php',
		'transaction_status' => '/validator/api/merchantTransIDvalidationAPI.php',
		'order_validate' => '/validator/api/validationserverAPI.php',
		'refund_payment' => '/validator/api/merchantTransIDvalidationAPI.php',
		'refund_status' => '/validator/api/merchantTransIDvalidationAPI.php',
	],
	'apiDomain' => $apiDomain,
	'connect_from_localhost' => filter_var(env('IS_LOCALHOST', false), FILTER_VALIDATE_BOOLEAN),
	'success_url' => '/payment/success',
	'failed_url' => '/sslcommerz/fail',
	'cancel_url' => '/sslcommerz/cancel',
	'ipn_url' => '/sslcommerz/ipn',
];
