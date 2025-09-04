<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {

        $allSessionData = Session::all();
    

        $activeRoleSessions = [];
        foreach ($allSessionData as $key => $value) {
            if (str_starts_with($key, 'active_role_id')) {
                $activeRoleSessions[$key] = $value;
            }
        }
    
        $userId = Auth::id();
        Cache::forget('user-online-' . $userId);
    
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
    
        foreach ($activeRoleSessions as $key => $value) {
            Session::put($key, $value);
        }
    }
    
}
