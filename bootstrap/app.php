<?php

use App\Http\Middleware\UserOnline;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PermitOfMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

$webRoutes = $apiRoutes = [];
foreach (glob(__DIR__ . '/../Modules/*/routes/web.php') as $routeFile) {
    $webRoutes[] = $routeFile;
}

foreach (glob(__DIR__ . '/../Modules/*/routes/api.php') as $routeFile) {
    $apiRoutes[] = $routeFile;
}


$webRoutes[] = __DIR__ . '/../routes/web.php';
$apiRoutes[] = __DIR__ . '/../routes/api.php';

use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: $webRoutes,
        api: $apiRoutes,
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permit-of' => PermitOfMiddleware::class,
            'onlineUser' => UserOnline::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'locale' => \App\Http\Middleware\CheckLocale::class,
            'maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
            'enabled' => \App\Http\Middleware\CheckModuleEnabled::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'payfast/webhook',
            'payment/success',
            'api/*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // dd($exceptions);
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(
                    ['status' => Response::HTTP_UNAUTHORIZED]
                        + (!empty($e->getMessage()) ? ['message' => $e->getMessage()] : []),
                    Response::HTTP_UNAUTHORIZED
                );
            }
        });

        $exceptions->render(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => $e->getMessage() ?: __()('auth.unauthorized_role'),
                ], Response::HTTP_FORBIDDEN);
            }
        });
    })
    ->withSchedule(function (Schedule $schedule) {
        if (Schema::hasTable('optionbuilder__settings')) {
            if (\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup')) {
                $frequency = setting('_badges.job_frequency') ?? 'daily';
                $schedule->command('assign:badges')->{$frequency}();
            }

            $schedule->command('orders:delete-pending-orders')->daily();
        }
    })
    ->create();
