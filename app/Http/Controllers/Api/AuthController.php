<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SocialLoginRequest;
use App\Http\Requests\Auth\SocialProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use App\Services\RegisterService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * Register api
     * @param App\Http\Requests\Auth\RegisterUserRequest
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(RegisterUserRequest $request)
    {

        $response = isDemoSite();
        if ($response) {
            return $this->error(data: null, message: __('general.demosite_res_txt'), code: Response::HTTP_FORBIDDEN);
        }

        $registerService                = new RegisterService();
        $user                           = $registerService->registerUser($request);
        $success['token']               = $user->token;
        $success['user']                = new UserResource($user);
        $success['email_verfied']       = $user->email_verified_at;
        return $this->success($success, __('api.user_register_successfully'));
    }

    /**
     * Login api
     * @param App\Http\Requests\Auth\LoginRequest
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginRequest $request)
    {
        $user = (new RegisterService())->getUserByEmail($request->email);

        if (! $user || $user->status !== 'active') {
            return $this->error(__('api.credentials_not_matched'));
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            return $this->sendUserResponse($user);
        } else {
            return $this->error(__('api.credentials_not_matched'));
        }
    }

    /**
     * Social Login
     * @param App\Http\Requests\Auth\SocialLoginRequest
     * @return \Illuminate\Http\JsonResponse
     */

    public function socialLogin(SocialLoginRequest $request)
    {
        $response = isDemoSite();
        if ($response) {
            return $this->error(data: null, message: __('general.demosite_res_txt'), code: Response::HTTP_FORBIDDEN);
        }
        $socialUser = (new RegisterService())->checkGoogleLoginWithCode($request->auth_code);

        if (empty($socialUser['success'])) {
            return $this->error(message: $socialUser['message'], code: Response::HTTP_UNAUTHORIZED);
        }

        $user = (new RegisterService())->createSocialUser($socialUser['user']->getEmail(), $socialUser['user']->getId(), $request->provider);
        $profile = (new ProfileService($user->id))->getUserProfile();

        if (empty($profile)) {
            return $this->error(message: __('api.social_login_profile_missing'), code: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Auth::login($user, true);
        return $this->sendUserResponse($user);
    }

    /**
     * Create User Social Profile
     * @param App\Http\Requests\Auth\SocialProfileRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSocialProfile(SocialProfileRequest $request)
    {
        $response = isDemoSite();
        if ($response) {
            return $this->error(data: null, message: __('general.demosite_res_txt'), code: Response::HTTP_FORBIDDEN);
        }
        $user = (new RegisterService())->getUserByEmail($request->email);
        if (empty($user)) {
            return $this->error(message: __('api.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $user = (new RegisterService)->completeSocialProfile($user, $request->all());
        $user->status = 'active';
        $user->default_role = $request->user_role;
        $user->save();

        Auth::login($user, true);
        return $this->sendUserResponse($user);
    }

    /**
     * Login User & return Response
     * @param \App\Models\User
     * @return \Illuminate\Http\JsonResponse
     */

    protected function sendUserResponse($user)
    {
        $user->load([
            'profile:id,user_id,first_name,last_name,gender,recommend_tutor,intro_video,native_language,verified_at,slug,image,tagline,description,created_at,updated_at',
            'address:country_id,state_id,city,address,zipcode',
            'roles',
            'userWallet:id,user_id,amount'
        ]);


        $user->tokens()->where('name', 'lernen')->delete();
        $success['token']   =  $user->createToken('lernen', ['*'], now()->addDays(7))->plainTextToken;

        $success['user']    =  new UserResource($user);
        if (!empty($user->email_verified_at)) {
            return $this->success($success, __('api.user_login_successfully'));
        } else {
            return $this->error(__('api.user_not_verified'), $success);
        }
    }

    /**
     * Resend Email
     * @return \Illuminate\Http\JsonResponse
     */

    public function resendEmail()
    {

        $registerService  = new RegisterService();
        $user             = Auth::user();
        $response         = $registerService->sendEmailVerificationNotification($user);
        if ($response) {
            return $this->success(message: __('api.email_send_successfully'));
        }
    }

    /**
     *  resetEmailPassword
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */

    public function resetEmailPassword(Request $request)
    {
        $response = isDemoSite();
        if ($response) {
            return $this->error(data: null, message: __('general.demosite_res_txt'), code: Response::HTTP_FORBIDDEN);
        }
        $request->validate([
            'email' => 'required|email',
        ]);
        $registerService  = new RegisterService();
        $response         = $registerService->sendPasswordResetLink($request);
        if (empty($response['success'])) {
            return $this->error(message: __($response['message']));
        }
        return $this->success(message: __($response['message']));
    }


    /**
     * Reset Password
     * @param App\Http\Requests\Auth\ResetPasswordRequest
     * @return \Illuminate\Http\JsonResponse
     */

    public function resetPassword(ResetPasswordRequest $request)
    {

        $response = isDemoSite();
        if ($response) {
            return $this->error(data: null, message: __('general.demosite_res_txt'), code: Response::HTTP_FORBIDDEN);
        }

        $registerService  = new RegisterService();
        $response = $registerService->resetPassword($request);

        if (empty($response['success'])) {
            return $this->error(message: __($response['message']));
        } else {
            return $this->success(message: __($response['message']));
        }
    }

    /**
     *  Logout
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */

    public function logout(Request $request)
    {
        $response = $request->user()->currentAccessToken()->delete();
        if ($response) {
            return $this->success(message: __('api.user_logout_successfully'));
        }
    }
}
