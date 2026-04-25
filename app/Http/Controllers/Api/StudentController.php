<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Booking\SendMessageRequest;
use App\Http\Resources\TutorRating\TutorCollection;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use ApiResponser;

    public function sendMessage(SendMessageRequest $request,$recepientId)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(data: null,message: __('general.demosite_res_txt'),code: Response::HTTP_FORBIDDEN);
        }
        $threadInfo = sendMessage($recepientId, Auth::user()->id, $request->message);
        if ($threadInfo) {
            return $this->success(data: $threadInfo, code: Response::HTTP_OK);
        } else {
            return $this->error(data: null,message: __('api.failed_to_send_message'),code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getStudentReviews($tutorId,Request $request)
    {
        if (empty($tutorId)) {
            return $this->error(data: null,message: __('api.invalid_parameters'),code: Response::HTTP_BAD_REQUEST);
        }

        $tutor          = User::where('id', $tutorId)->first();
        if (!$tutor) {
            return $this->error(data: null,message: __('api.tutor_not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if ($tutor->role !== 'tutor') {
            return $this->error(data: null,message: __('api.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }
        $userService    = new UserService($tutor);
        $utorRatings    = $userService->getTutorRatings($tutor->id,$request->rating);
        return $this->success(data: new TutorCollection($utorRatings));

    }

}
