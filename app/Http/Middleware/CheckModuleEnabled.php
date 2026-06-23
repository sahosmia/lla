<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module): Response
    {
        if(Module::isDisabled($module)){
            abort(404);
        }
        return $next($request);
    }
}
