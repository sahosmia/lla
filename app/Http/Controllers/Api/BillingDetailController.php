<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\BillingDetail\BillingDetailStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\BillingService;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BillingDetailController extends Controller
{
    use ApiResponser;

    public function show($id)
    {
        $user = User::find($id);
        if(empty($user)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($user->id != Auth::user()?->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $user->load(['billingDetail']);
        return $this->success(data: new UserResource($user));
    }

    public function store(BillingDetailStoreRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $user = User::find(Auth::user()->id);
        if(empty($user)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        } 

        if($user->role == 'tutor'){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $billingService = new BillingService(Auth::user());
        $billingInfo    = $billingService->getBillingDetail();
        if(!empty($billingInfo)){
            return $this->error(data: null,message: __('api.already_exists'),code: Response::HTTP_NOT_FOUND);
        }
        $billingDetail = [
            'user_id'            => Auth::user()->id,
            'first_name'         => $request->firstName,
            'last_name'          => $request->lastName,
            'phone'              => $request->phone,
            'email'              => $request->email,
            'company'            => $request->company,
        ];

        $addressData = [
            'country_id'        => $request->country,
            'state_id'          => $request->state,
            'city'              => $request->city,
            'address'           => $request->address,
            'zipcode'           => $request->zipcode,
            'lat'               => $request->lat ?? 0,
            'long'              => $request->long ?? 0 ,
        ];

        $billinginfo = $billingService->storeBillingDetail($billingDetail);
        if ($billinginfo) {
           $billingService->storeBillingAddress($billinginfo->id, $addressData);
       }

     
       $user->load(['billingDetail']);
       return $this->success(data: new UserResource($user),message: __('api.billing_detail_added_successfully'));
    }

    public function update(BillingDetailStoreRequest $request, $id)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        $user = Auth::user();
         
        if($user->role == 'tutor'){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }
        
        $billingService = new BillingService(Auth::user());

        $billingInfo    = $billingService->getBillingDetail();

        if($billingInfo->id != $id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        if(empty($billingInfo)){
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }
    
        $billingDetail = [
            'user_id'            => Auth::user()->id,
            'first_name'         => $request->firstName,
            'last_name'          => $request->lastName,
            'phone'              => $request->phone,
            'email'              => $request->email,
            'company'            => $request->company,
        ];

        $addressData = [
            'country_id'        => $request->country,
            'state_id'          => $request->state,
            'city'              => $request->city,
            'address'           => $request->address,
            'zipcode'           => $request->zipcode,
            'lat'               => $request->lat ?? 0,
            'long'              => $request->long ?? 0 ,
        ];

        $billinginfo = $billingService->storeBillingDetail($billingDetail);
        if ($billinginfo) {
           $billingService->storeBillingAddress($billinginfo->id, $addressData);
        }

       $user->load(['billingDetail']);
       return $this->success(data: new UserResource($user),message: __('api.billing_detail_updated_successfully'));
    }

}
