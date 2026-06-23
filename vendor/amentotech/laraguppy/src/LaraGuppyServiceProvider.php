<?php
namespace Amentotech\LaraGuppy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Amentotech\LaraGuppy\Listeners\LoginEventListener;
use Amentotech\LaraGuppy\Listeners\LogoutEventListener;
use Illuminate\Auth\Events\Login;
use Exception;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

class LaraGuppyServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $configPath = __DIR__ . '/../config/laraguppy.php';
        $this->mergeConfigFrom($configPath, 'laraguppy');
        require_once('ConfigurationManager.php');
        require_once('Helpers.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laraguppy');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'laraguppy');
        
        Route::prefix('api')
        ->middleware('api')
        ->group(function () {
            require __DIR__.'/../routes/api.php';
        });

        Route::middleware(['web'])->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->app->booted(function () {
                Route::middleware(['api', 'auth:sanctum'])->post('/api/broadcasting/auth', function (Request $request) {
            return Broadcast::auth($request);
        });

        if (file_exists($channels = __DIR__ . '/../routes/channels.php')) {
                require $channels;
            }
        });

        $this->publishes([
            __DIR__.'/../config/laraguppy.php' => config_path('laraguppy.php')
        ], 'config');
        
        $this->publishes([
            __DIR__.'/../public/build'              => public_path('vendor/laraguppy'),
            __DIR__.'/../public/js/jquery.min.js'   => public_path('vendor/laraguppy/jquery.min.js')
        ], 'assets');

        if( !$this->app->runningInConsole() ){
            if ( empty(config('laraguppy')) ) {
                throw new Exception("No laraguppy config found, please run: php artisan vendor:publish --provider=\"Amentotech\LaraGuppy\LaraGuppyServiceProvider\" --tag=config");
            }
        }

        Event::listen(Login::class, LoginEventListener::class);
        Event::listen(Logout::class, LogoutEventListener::class);
    }
}

