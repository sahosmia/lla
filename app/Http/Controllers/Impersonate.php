<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Impersonate extends Controller
{
    public function exitImpersonate()
    {
        if (!session()->has('impersonated_id')) {
            abort(404);
        }

        session()->forget('impersonated_id');
        session()->forget('userId');
        session()->forget('impersonated_name');
        session()->forget('profileId');
        session()->forget('roleId');
        session()->forget('roleName');

        $user = User::find(session()->get('admin_id'));
        Auth::login($user);
        session()->forget('admin_id');
        return redirect()->route('admin.users');
    }
}
