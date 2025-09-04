<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavouriteTutorController extends Controller
{
    use ApiResponser;

    public function index()
    {

        if (Auth::user()->role  !== 'student') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $userService  = new UserService(Auth::user());
        $favourites   = $userService->getFavouriteUsers()
        ->with(['profile:id,user_id,slug,first_name,last_name,image,native_language,verified_at',
                'address:id,addressable_id,addressable_type,country_id','languages:id,name'])
        ->with(['subjects' => function ($query) {
            $query->withCount('slots as sessions');
            $query->with('subject:id,name')->take(1);
        }])
        ->withMin('subjects as min_price', 'hour_rate')
        ->withAvg('reviews', 'rating')
        ->withCount(['bookingSlots as active_students' => function($query){
            $query->whereStatus('active');
        }])
        ->get();
        return $this->success(data: UserResource::collection($favourites));
    }

    public function update($userId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $userService = new UserService(Auth::user());

        $user = User::find($userId)?->load('profile');

        if(empty($user)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if ($user->role  !== 'tutor') {
            return $this->error(data: null,message: __('api.only_tutors_can_be_added_to_favorites'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()->role  !== 'student') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $isFavourite = $userService->isFavouriteUser($userId);

        if ($isFavourite) {
            $userService->removeFromFavourite($userId);
            $message = $user->profile->full_name . ' ' . __('api.has_been_removed_from_favorites');
        } else {
            $userService->addToFavourite($userId);
            $message = $user->profile->full_name . ' ' . __('api.has_been_added_to_favorites');
        }

        return $this->success(null, $message);

    }
}
