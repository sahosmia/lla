<?php
use Illuminate\Support\Facades\Route;
use Amentotech\LaraGuppy\Http\Controllers\ChatActionsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$routes = Route::controller(ChatActionsController::class);

if( !empty(config('laraguppy.url_prefix')) ){
    $routes = $routes->prefix(config('laraguppy.url_prefix'));
}

if( !empty(config('laraguppy.route_middleware')) ){
    $routes = $routes->middleware(config('laraguppy.route_middleware'));
}

$routes->group( function () {
    Route::get('messenger', 'index')->name('laraguppy.messenger');
});