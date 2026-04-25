<?php

use Illuminate\Http\Request;
use Larabuild\Pagebuilder\Http\Controllers\PageBuilderController;

use Larabuild\Pagebuilder\Http\Controllers\PageController;

use Illuminate\Support\Facades\Route;

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

$page = Route::controller(PageController::class);
$pBuilder = Route::controller(PageBuilderController::class);

$middleware = ['permit-of:can-manage-pages'];

if (!empty(config('pagebuilder.url_prefix'))) {
    $page = $page->prefix(config('pagebuilder.url_prefix'));
    $pBuilder = $pBuilder->prefix(config('pagebuilder.url_prefix'));
}

if (!empty(config('pagebuilder.route_middleware'))) {
    $middleware = array_merge($middleware, config('pagebuilder.route_middleware'));
}

$page->middleware($middleware)->group(function () {
    Route::get('pages', 'index')->name('pagebuilder');
    Route::get('pages/{page}/edit', 'edit')->name('page.edit');
    Route::post('pages', 'store')->name('page.store');
    Route::put('pages/{page}', 'update')->name('page.update');
    Route::get('pages/create', 'create')->name('page.create');
    Route::delete('pages/{page}', 'destroy')->name('page.delete');
});

$pBuilder->middleware($middleware)->group(function () {
    Route::get('pages/{id}/build', 'build')->name('pagebuilder.build');
    Route::post('pages/{id}/store', 'storeComponentData')->name('pagebuilder.store-component-data');
    Route::post('get-section-settings', 'getSettings')->name('pagebuilder.get-section-settings');
    Route::post('set-section-settings', 'setSectionSettings')->name('pagebuilder.set-section-settings');
    Route::post('set-page-settings', 'setPageSettings')->name('pagebuilder.set-page-settings');
});
Route::middleware($middleware)->get('get-pb-section', [PageBuilderController::class, 'getPageSectionHtml'])->name('pagebuilder.html');

Route::middleware($middleware)->get('pages/{id}/iframe', [PageBuilderController::class, 'iframe'])->name('pagebuilder.iframe');

Route::any('/{any}', function (Request $request) {
    $builder = new PageBuilderController();
    return $builder->renderPage($request->path());
})->where('any', '.*')->name('pagebuilder.page');
