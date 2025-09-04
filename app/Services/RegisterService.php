<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class RegisterService
{

    public function registerUser($request): User
    {
        $user = User::create([
            'default_role'  => $request['user_role'],
            'email'         => $request['email'],
            'password'      => Hash::make($request['password']),
        ]);
        $user->profile()->create([
            'first_name'    => $request['first_name'],
            'last_name'     => $request['last_name'],
            'phone_number'  => $request['phone_number']
        ]);


        $user->assignRole($request['user_role']);

        $emailData = ['userName' => $user->profile->full_name, 'userEmail' => $user->email, 'key' => $user->getKey()];

        dispatch(new SendNotificationJob('registration', $user, $emailData));
        dispatch(new SendNotificationJob('registration', User::admin(), $emailData));

        $user->token = $user->createToken('learnen')->plainTextToken;

        return $user;
    }

    public function completeSocialProfile($user, $request): User
    {
        $user->profile()->create([
            'first_name' => $request['first_name'],
            'last_name'  => $request['last_name'],
            'phone_number' => $request['phone_number']
        ]);


        $user->assignRole($request['user_role']);

        $emailData = ['userName' => $user->profile->full_name, 'userEmail' => $user->email, 'key' => $user->getKey()];

        dispatch(new SendNotificationJob('welcome', $user, $emailData));
        dispatch(new SendNotificationJob('welcome', User::admin(), $emailData));

        return $user;
    }

    public function sendEmailVerificationNotification($user)
    {
        $emailData = ['userName' => $user->profile->full_name, 'userEmail' => $user->email, 'key' => $user->getKey()];
        dispatch(new SendNotificationJob('emailVerification', $user, $emailData));
        return true;
    }

    public function sendPasswordResetLink($request): array
    {

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status != Password::RESET_LINK_SENT) {
            return [
                'success' => false,
                'message' => $status
            ];
        }
        return [
            'success' => true,
            'message' => $status
        ];
    }

    /**
     * Reset the password for the given user.
     */

    public function resetPassword($request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        if ($status != Password::PASSWORD_RESET) {
            return [
                'success' => false,
                'message' => $status
            ];
        }
        return [
            'success' => true,
            'message' => $status
        ];
    }

    /**
     * Create Social User
     * @param string $email
     * @param string $providerid
     * @param string $provider
     * @return App\Models\User
     */

    public function createSocialUser($email, $providerid, $provider = 'google'): User
    {

        $user = User::where('provider_id', $providerid)
            ->where('provider', $provider)
            ->first();

        if (!$user) {
            // Check if a user with the same email exists
            $existingUser = $this->getUserByEmail($email);

            if ($existingUser) {
                // Update existing user with provider details
                $existingUser->update([
                    'provider'    => $provider,
                    'provider_id' => $providerid,
                ]);
                $user = $existingUser;
            } else {
                // Create a new user
                $user = User::create([
                    'email'        => $email,
                    'provider'     => $provider,
                    'provider_id'  => $providerid,
                    'password'     => bcrypt(Str::random(20)),
                ]);
                $user->email_verified_at = now();
                $user->status = 0;
                $user->save();
            }
        }

        return $user;
    }

    /**
     * Get User By Email
     * @param string $email
     * @return \App\Models\User
     */

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Check Social Login user is valid
     * @param string $authCode
     * @return array
     */

    public function checkGoogleLoginWithCode($authCode): array
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'code' => $authCode,
            'grant_type' => 'authorization_code',
        ]);

        if ($response->failed()) {
            Log::info($response);
            return ['success' => false, 'message' => __('api.google_social_login_error')];
        }

        $tokenData = $response->json();
        $accessToken = $tokenData['access_token'];

        try {
            $googleUser = Socialite::driver('google')->userFromToken($accessToken);
            return ['success' => true, 'user' => $googleUser];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => __('api.invalid_google_token')];
        }
    }
}
