<?php

use Illuminate\Support\Facades\Route;
use Modules\Upcertify\Http\Controllers\Api\CertificateController;

Route::middleware('auth:sanctum')->prefix('upcertify')->group(function () {

    Route::middleware('role:tutor')->group(function () {
        Route::get('certificates-list',                           [CertificateController::class, 'certificateList']);
        Route::delete('certificate/{id}',                         [CertificateController::class, 'deleteCertificate']);
    });

    Route::prefix('student')->middleware('role:student')->group(function () {
        Route::get('certificates',                           [CertificateController::class, 'studentCertificateList']);
    });
});
