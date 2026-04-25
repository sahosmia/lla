<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\Education\EducationStoreRequest;
use App\Http\Resources\EducationResource;
use App\Models\User;
use App\Services\EducationService;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        if(!empty(request()->bearerToken())){
            $this->middleware('auth:sanctum');
        }
    }

    public function show($tutorId)
    {
        if (empty($tutorId)) {
            return $this->error(data: null,message: __('api.invalid_parameters'),code: Response::HTTP_BAD_REQUEST);
        }

        $tutor = User::where('id', $tutorId)->first();

        if (!$tutor) {
            return $this->error(data: null,message: __('api.tutor_not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if ($tutor?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $educationService      = new EducationService($tutor);
        $educations            = $educationService->getUserEducations();
        return $this->success(data: EducationResource::collection($educations));
    }

    public function store(EducationStoreRequest $request)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $educationService = new EducationService(Auth::user());

        $educationDetail = [
            'course_title'          => $request->course_title,
            'institute_name'        => $request->institute_name,
            'country_id'            => $request->country,
            'city'                  => $request->city,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'ongoing'               => $request->ongoing,
            'description'           => $request->description,

        ];

        $eduction     = $educationService->setUserEducation($educationDetail);
        return $this->success(data: new EducationResource($eduction),message: __('api.education_added_successfully'));
    }

    public function update(EducationStoreRequest $request,$educationId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $educationService   = new EducationService(Auth::user());
        $eduction           = $educationService->getUserEducation($educationId);
        
        if (empty($eduction)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }
        
        if($eduction?->user_id != Auth::user()?->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }


        $educationDetail = [
            'id'                    => $educationId,
            'course_title'          => $request->course_title,
            'institute_name'        => $request->institute_name,
            'country_id'            => $request->country,
            'city'                  => $request->city,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'ongoing'               => $request->ongoing,
            'description'           => $request->description,

        ];

        $eductions     = $educationService->setUserEducation($educationDetail);
        return $this->success(data: new EducationResource($eductions),message: __('api.education_updated_successfully'));
    }

     public function destroy($educationId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        
        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $educationService   = new EducationService(Auth::user());

        $eduction           = $educationService->getUserEducation($educationId);
        if (empty($eduction)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $educationService->deleteEducation($educationId);
        return $this->success(data: null,message: __('api.education_deleted_successfully'));
    }

}
