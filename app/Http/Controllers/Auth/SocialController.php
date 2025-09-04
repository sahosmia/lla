<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ProfileService;
use App\Services\RegisterService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    /**
     * Redirect the user to the social provider authentication page.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirect($provider)
    {
        if (empty(setting('_api.enable_social_login')) || !in_array($provider, ['google', 'facebook', 'github'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from social provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function callback($provider)
    {
        if (empty(setting('_api.enable_social_login')) || !in_array($provider, ['google', 'facebook', 'github'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', __('auth.social_login_error', ['platform' => ucfirst($provider)]));
        }

        $user = (new RegisterService())->createSocialUser($socialUser->getEmail(), $socialUser->getId(), $provider);

        $profile = (new ProfileService($user->id))->getUserProfile();
        if (empty($profile)) {
            session(['name' => $socialUser->getName(), 'email' => $socialUser->getEmail()]);
            return redirect()->route('social-profile');
        }

        Auth::login($user, true);

        if ($user->roles()?->first()?->name == 'tutor') {
            return redirect()->route('tutor.dashboard');
        } else {
            return redirect()->route('student.bookings');
        }
    }
}
