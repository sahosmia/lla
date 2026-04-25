<?php

use Illuminate\Support\Facades\Route;
use Larabuild\Optionbuilder\Http\Controllers\OptionBuilderController;

$routes = Route::controller(OptionBuilderController::class);

if (!empty(config('optionbuilder.url_prefix'))) {
    $routes = $routes->prefix(config('optionbuilder.url_prefix'));
}

if (!empty(config('optionbuilder.route_middleware'))) {
    $routes = $routes->middleware(config('optionbuilder.route_middleware'));
}

$routes->group(function () {
    Route::get('option-builder',  'index')->name('optionbuilder');
    Route::post('option-builder/update-section-settings',  'updateSettings')->name('optionbuilder.update-section-settings');
    Route::post('option-builder/reset-section-settings',    'resetSettings')->name('optionbuilder.reset-section-settings');
    Route::post('option-builder/upload-files',              'uploadFiles')->name('optionbuilder.upload-files');
});
