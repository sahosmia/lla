<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\Certificate\CertificateStoreRequest;
use App\Http\Resources\CertificationResource;
use App\Models\User;
use App\Services\CertificateService;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificationController extends Controller
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

            $certificateService   = new CertificateService($tutor);
            $certificates         = $certificateService->getUserCertificates();
            return $this->success(data: CertificationResource::collection($certificates));
    }

    public function store(CertificateStoreRequest $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $certificateService = new CertificateService(Auth::user());


        
        $certificateDetail = [
            'title'               => $request->title,
            'institute_name'      => $request->institute_name,
            'issue_date'          => $request->issue_date,
            'expiry_date'         => $request->expiry_date,
            'description'         => $request->description,
        ];

        if ($request->hasFile('image')) {
            $fileName    = uniqueFileName('public/certificates', $request->image->getClientOriginalName());
            $certificateDetail['image'] = $request->image->storeAs('certificates', $fileName, getStorageDisk());
        } else {
            $certificateDetail['image'] = $request->image;
        }

        $certifications     = $certificateService->setUserCertificate($certificateDetail);
        return $this->success(data: new CertificationResource($certifications),message: __('api.certificate_added_successfully'));
    }

    public function update(CertificateStoreRequest $request,$certificateId)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $certificateService   = new CertificateService(Auth::user());
        $certificate          = $certificateService->getUserCertificate($certificateId);

        if (empty($certificate)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($certificate?->user_id != Auth::user()?->id){
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }
        
        $certificateDetail = [
            'id'                  => $certificateId,
            'title'               => $request->title,
            'institute_name'      => $request->institute_name,
            'issue_date'          => $request->issue_date,
            'expiry_date'         => $request->expiry_date,
            'description'         => $request->description,

        ];

        if ($request->hasFile('image')) {
            $fileName    = uniqueFileName('public/certificates', $request->image->getClientOriginalName());
            $certificateDetail['image'] = $request->image->storeAs('certificates', $fileName, getStorageDisk());
        } else {
            $certificateDetail['image'] = $request->image;
        }

        $certificates     = $certificateService->setUserCertificate($certificateDetail);
        return $this->success(data: new CertificationResource($certificates),message: __('api.certificate_updated_successfully'));
    }

    public function destroy($certificateId)
    {

        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        if (Auth::user()?->role != 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $certificateService   = new CertificateService(Auth::user());
        $certificate          = $certificateService->getUserCertificate($certificateId);

        if (empty($certificate)) {
            return $this->error(data: null,message: __('api.not_found'),code: Response::HTTP_NOT_FOUND);
        }

        $certificates     = $certificateService->deleteCertificate($certificateId);
        return $this->success(data: null,message: __('api.certificate_deleted_successfully'));
    }


}
