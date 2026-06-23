<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\PersonalDetail\PersonalDetailRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use ApiResponser;

    public function getProfile($id)
    {

        $user = User::find($id);
        
        if(empty($user)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $user->load(['profile', 'address', 'languages:id,name']);
        return $this->success(data: new UserResource($user),message: __('api.profile_data_retrieved_successfully'));
    }

    public function updateProfile(PersonalDetailRequest $request,$id)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        
        if($id != Auth::user()?->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $profileService     = new ProfileService(Auth::user()?->id);
        $user               = User::find(Auth::user()?->id);

        if (!$user) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $profileData = [
            'user_id'            => $user?->id,
            'first_name'         => $request?->first_name,
            'last_name'          => $request?->last_name,
            'phone_number'       => $request?->phone_number,
            'gender'             => $request?->gender,
            'native_language'    => $request?->native_language,
            'description'        => $request?->description,
            'tagline'            => $request?->tagline,
            'recommend_tutor'    => $request?->recommend_tutor ?? 'no',
        ];
        
        if ($request->hasFile('image')) {
            $fileName    = uniqueFileName('public/profile', $request->image->getClientOriginalName());
            $profileData['image'] = $request->image->storeAs('profile', $fileName, getStorageDisk());
        } else {
            $profileData['image'] = $request?->image;
        }
         
        if ($request->hasFile('intro_video')) {
            $fileName = uniqueFileName('public/profile_videos', $request->intro_video->getClientOriginalName());
            $profileData['intro_video'] = $request->intro_video->storeAs('profile_videos', $fileName, getStorageDisk());
        } else {
            $profileData['intro_video'] = $request?->intro_video;
        }
        
        $languagesData = $request?->user_languages;
        $languagesData = array_unique($languagesData);
        $addressData = [
            'country_id'        => $request?->country,
            'state_id'          => $request?->state,
            'city'              => $request?->city,
            'address'           => $request?->address,
            'zipcode'           => $request?->zipcode,
            'lat'               => $request?->lat ?? 0,
            'long'              => $request?->long ?? 0 ,
        ];

        $profileService->setUserProfile($profileData);
        $profileService->storeUserLanguages($languagesData);
        $profileService->setUserAddress($addressData);

        $userProfile = $user->load(['profile', 'Languages', 'address']);
        return $this->success(message: __('api.profile_data_updated_successfully') ,data: new UserResource($userProfile),code: Response::HTTP_OK);
    }
}
