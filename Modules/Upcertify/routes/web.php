<?php

use Modules\Upcertify\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;

$routes = Route::as('upcertify.')->controller(CertificateController::class);


if( !empty(config('upcertify.url_prefix')) ){
    $routes = $routes->prefix(config('upcertify.url_prefix'));
}

$middleware = ['enabled:upcertify', 'locale', 'maintenance'];

if( !empty(config('upcertify.route_middleware')) ){
    $middleware = array_merge($middleware, config('upcertify.route_middleware'));
}

$routes = $routes->middleware($middleware);

$routes->group(function () {
    Route::get('update/{id}', CertificateController::class)->name('update');
    Route::get('certificate-list', [CertificateController::class, 'certificateList'])->name('certificate-list');
});

Route::get('upcertify/certificate/{uid}', [CertificateController::class, 'viewCertificate'])->name('upcertify.certificate');
Route::get('upcertify/download/{uid}', [CertificateController::class, 'getCertificate'])->name('upcertify.download');
Route::get('upcertify/certificate-short/{uid}', [CertificateController::class, 'takeCertificateShort'])->name('upcertify.certificate-short');
