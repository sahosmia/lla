<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = User::findOrFail($request->route('id'));
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);  
            return redirect()->to($user->redirect_after_login . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            Auth::login($user);
        }

        return redirect()->to($user->redirect_after_login . '?verified=1');
    }
}
