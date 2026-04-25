<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Common\AccountSetting\AccountSettingStoreRequest;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;

class AccountSettingController extends Controller
{
    use ApiResponser;

    public function updatePassword(AccountSettingStoreRequest $request, $id) {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        if($id != Auth::user()->id){
            return $this->error(message: __('api.user_not_found'));
        }
        $userService = new UserService(Auth::user());
        $userService->setUserPassword($request->password);
        return $this->success(message: __('api.password_updated_successfully'));
    }

    public function updateTimezone(Request $request, $id) {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $validatedRequest = new AccountSettingStoreRequest();
        $rules = $validatedRequest->timezone();
        $validatedData = $request->validate($rules);

        if($id != Auth::user()->id){
            return $this->error(message: __('api.user_not_found'));
        }
        $userService = new UserService(Auth::user());
        $userService->setAccountSetting('timezone',[$request->timezone]);
        return $this->success(message: __('api.timezone_updated_successfully'));
    }
    public function getTimezone() {
        $userService = new UserService(Auth::user());
        $timezone = $userService->getAccountSetting('timezone');
        if(!$timezone){
            return $this->error(message: __('api.timezone_not_found'));
        }
        return $this->success(message: __('api.timezone_fetched_successfully'), data: $timezone);
    }
}
