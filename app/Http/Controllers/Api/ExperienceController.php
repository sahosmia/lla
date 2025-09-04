<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\Experience\ExperienceStoreRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\User;
use App\Services\ExperienceService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExperienceController extends Controller
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
        
        if ($tutor?->role !== 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $experiencesService    = new ExperienceService($tutor);
        $experience            = $experiencesService->getUserExperiences();
        return $this->success(data: ExperienceResource::collection($experience));

    }

    public function store(ExperienceStoreRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $experiencesService = new ExperienceService(Auth::user());

        $experienceDetail = [
            'title'             => $request->title,
            'employment_type'   => $request->employment_type,
            'company'           => $request->company,
            'location'          => $request->location,
            'country_id'        => $request->country,
            'city'              => $request->city,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'is_current'        => $request->is_current,
            'description'       => $request->description,


        ];

        $experience     = $experiencesService->setUserExperience($experienceDetail);
        return $this->success(data: new ExperienceResource($experience),message: __('api.experience_added_successfully'));
    }

    public function update(ExperienceStoreRequest $request,$experienceId)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }

        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $experiencesService   = new ExperienceService(Auth::user());
        $experience           = $experiencesService->getUseExperience($experienceId);

        if (empty($experience)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($experience?->user_id != Auth::user()?->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $experienceDetail = [
            'id'                    => $experienceId,
            'title'                 => $request->title,
            'employment_type'       => $request->employment_type,
            'company'               => $request->company,
            'location'              => $request->location,
            'country_id'            => $request->country,
            'city'                  => $request->city,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'is_current'            => $request->is_current,
            'description'           => $request->description,

        ];

        $experiences     = $experiencesService->setUserExperience($experienceDetail);
        return $this->success(data: new ExperienceResource($experiences),message: __('api.experience_updated_successfully'));
    }

    public function destroy($experienceId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $experiencesService   = new ExperienceService(Auth::user());
        $experience           = $experiencesService->getUseExperience($experienceId);

        if (empty($experience)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $experiencesService->deleteExperience($experienceId);
        return $this->success(data: null,message: __('api.experience_deleted_successfully'));
    }

}
