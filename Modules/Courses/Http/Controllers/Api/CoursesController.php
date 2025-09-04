<?php

namespace Modules\Courses\Http\Controllers\Api;

use App\Facades\Cart;
use Modules\Courses\Http\Resources\CoursesDetailResource;
use Modules\Courses\Http\Resources\CategoriesResource;
use Modules\Courses\Http\Resources\CoursesCollection;
use Modules\Courses\Http\Resources\EnrolledcoursesCollection;
use Modules\Courses\Http\Resources\EnrolledcoursesResource;
use Modules\Courses\Http\Resources\LanguageResource;
use Symfony\Component\HttpFoundation\Response;
use Modules\Courses\Services\CourseService;
use Modules\Courses\Services\CurriculumService;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Models\Like;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\User;
use App\Services\BookingService;
use Carbon\Carbon;
use Modules\Courses\Models\Course;

class CoursesController extends Controller
{
    use ApiResponser;

    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;

        $token = request()->bearerToken();

        $sanctumToken = PersonalAccessToken::findToken($token) ?? null;

        if (!empty($sanctumToken) && $sanctumToken->expires_at && Carbon::parse($sanctumToken->expires_at)->isFuture()) {
            $this->middleware('auth:sanctum');
        }
    }

    public function getCourses(Request $request)
    {
      
        $allowedParams = [
            'keyword', 'category', 'levels', 'languages', 'per_page', 
            'min_price', 'max_price', 'sort', 'avg_rating', 'duration', 'page','pricing_type'
        ];
    
        $requestParams    = array_keys($request->all());
        $unexpectedParams = array_diff($requestParams, $allowedParams);
    
        if (!empty($unexpectedParams)) {
            return response()->json([
                'error' => 'Invalid parameters detected',
                'invalid_params' => array_values($unexpectedParams)
            ], Response::HTTP_BAD_REQUEST);
        }

        $perPage = !empty($request->get('per_page')) ? $request->get('per_page') : 3;

        $courses = $this->courseService->getCourses(
            with: ['category','pricing','language',
                   'promotionalVideo','instructor',
                   'instructor.profile','likes',
                   'thumbnail',
                ],
            withCount: ['ratings', 'curriculums'],
            withAvg: [
                'ratings' => 'rating',
            ],
            filters: $request->all(),
            perPage: $perPage
        );

        if (auth()->check()) {
            $courses->each(function ($course) {
                $course->like_user_ids = $course->likes->pluck('user_id');
                collect($course->like_user_ids)->contains(auth()->id()) ? $course->is_favorite = true : $course->is_favorite = false;
            });
        }

        return $this->success(data: new CoursesCollection($courses));
    }

    public function getCategories()
    {
        $categories = $this->courseService->getCategories();
        return $this->success(data: CategoriesResource::collection($categories), code: Response::HTTP_OK);
    }

    public function getRatings(){
        $ratingCounts = $this->courseService->getCourseByRating()
        ->pluck('average_rating')
        ->filter(function ($value) {
            return !is_null($value);
        })
        ->countBy()
        ->sortDesc()
        ->toArray();

        foreach ([5, 4, 3, 2, 1] as $rating) {
            $ratingCounts[$rating] = $ratingCounts[$rating] ?? 0;
        }
        return $this->success(data: $ratingCounts, code: Response::HTTP_OK);
    }

    public function getDurationCounts(){

        $durationCounts = $this->courseService->getCourseByContentLength()
        ->pluck('course_count', 'duration_range')
        ->toArray();

        foreach (['0-1', '1-3', '3-6', '6-17', '17+'] as $range) {
            $durationCounts[$range] = $durationCounts[$range] ?? 0;
        }
        return $this->success(data: $durationCounts, code: Response::HTTP_OK);
    }

    public function getLevels(){

        $levels = $this->courseService->getLevels();
        return $this->success(data: $levels, code: Response::HTTP_OK);
    }

    public function getPrices(){

        $totalCourses = $this->courseService->getAllCourses(filters: ['status' => 'active'])->count();
        $paidCourses  = $this->courseService->getPaidCourses()->count();

        $price = [
            'total_courses' => $totalCourses,
            'paid_courses'  => $paidCourses
        ];
        return $this->success(data: $price, code: Response::HTTP_OK);
    }

    public function getLanguages(){
        $languages = $this->courseService->getLanguages();
        return $this->success(data: LanguageResource::collection($languages), code: Response::HTTP_OK);
    }

    public function getCourseDetail($slug){

        $isCourseExist = $this->courseService->getCourseBySlug($slug);
        if (empty($isCourseExist)) {
            return $this->error(message: __('courses::courses.course_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $course = $this->courseService->getCourse(
            slug: $slug,
            relations: [
                'category',
                'instructor',
                'instructor.languages',
                'instructor.profile',
                'instructor.socialProfiles',
                'instructor.address',
                'subCategory',
                'language',
                'thumbnail',
                'faqs',
                'promotionalVideo',
                'pricing',
                'enrollments',
                'sections' => function($query) {
                    $query->withWhereHas('curriculums', function($subQuery) {
                        $subQuery->orderBy('sort_order', 'asc');
                        $subQuery->whereNotNull('media_path')->orWhereNotNull('article_content');
                    });
                },
                'ratings.student.profile',
                'ratings.student.address'
            ],
            withAvg: [
                'ratings' => 'rating',
            ],
            withCount: [
                'ratings',
                'sections',
                'curriculums',
                'instructorReviews',
                'faqs',
                'enrollments',
                'instructor as active_students_count' => function ($query) { 
                    $query->withCount('courses')
                        ->join(config('courses.db_prefix') . 'courses', 'users.id', '=', config('courses.db_prefix') . 'courses.instructor_id')
                        ->join(config('courses.db_prefix') . 'enrollments', config('courses.db_prefix') . 'courses.id', '=', config('courses.db_prefix') . 'enrollments.course_id');
                },

            ],
            status: null
        );
        if (auth()->check()) {
            $enrollments = $course->enrollments->pluck('student_id');
            collect($enrollments)->contains(auth()->id()) || !empty(Cart::get($course->id, Course::class)) ? $course->is_enrolled = true : $course->is_enrolled = false;       
        }

        return $this->success(data: new CoursesDetailResource($course), code: Response::HTTP_OK);
    }

    public function likeCourse($id){

        $response = isDemoSite();
        if( $response ){
            return $this->error(message:  __('general.demosite_res_title'), code: Response::HTTP_FORBIDDEN);
        }
        if(auth()->user()?->role == 'tutor'){
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }
        $course = $this->courseService->getCourse($id);
        
        if (empty($course)) {
            return $this->error(message: __('courses::courses.course_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        if ($course->likes()->where('user_id', Auth::id())->exists()) {

            $course->likes()->where('user_id', Auth::id())->delete();
            return $this->success(data: null, message: __('courses::courses.course_unliked_successfully'), code: Response::HTTP_OK);
        } else {
            $course->likes()->create([
                'user_id' => Auth::id(),
            ]);
            return $this->success(data: null, message: __('courses::courses.course_liked_successfully'), code: Response::HTTP_OK);
        }
    }

    public function getCourseTaking($slug){

        if(auth()->user()?->role == 'admin'){
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }

        $course = $this->courseService->getCourse(
            slug: $slug,
            relations: [
                'category',
                'instructor',
                'instructor.languages',
                'instructor.profile:id,user_id,first_name,last_name,image,slug,tagline,gender,native_language,description,verified_at',
                'instructor.socialProfiles',
                'instructor.address',
                'subCategory',
                'language',
                'thumbnail',
                'promotionalVideo',
                'pricing',
                'noticeboards',
                'sections' => function ($query) {
                    $query->withWhereHas('curriculums', function ($subQuery) {
                        $subQuery->whereNotNull('media_path')->orWhereNotNull('article_content');
                        $subQuery->with('watchtime');
                        $subQuery->orderBy('sort_order', 'asc');
                    });
                },
                'ratings.student.profile',
                'ratings.student.address',
            ],
            withSum: [
                'courseWatchtime' => 'duration'  
            ],
            withAvg: [
                'ratings' => 'rating',
            ],
            withCount: [
                'ratings',
                'sections',
                'curriculums',
                'instructorReviews',
                'faqs',
                'enrollments',
                'instructor as active_students_count' => function ($query) { 
                    $query->withCount('courses')
                        ->join(config('courses.db_prefix') . 'courses', 'users.id', '=', config('courses.db_prefix') . 'courses.instructor_id')
                        ->join(config('courses.db_prefix') . 'enrollments', config('courses.db_prefix') . 'courses.id', '=', config('courses.db_prefix') . 'enrollments.course_id');
                },
            ],
            status: null
        );

        if (auth()->user()?->role == 'tutor' && $course?->instructor_id != Auth::id()) {
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }

        $courseAddedToStudent = (new CourseService())->getStudentCourse(
            courseId: $course->id,
            studentId: Auth::id(),
            tutorId: $course->instructor_id
        );

        if (auth()->user()?->role == 'student' && !$courseAddedToStudent) {
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }

        $progress = 0;

        if(!empty($course->course_watchtime_sum_duration) && !empty($course->content_length)) {
            $progress = floor(($course->course_watchtime_sum_duration / $course->content_length) * 100);
        }
        $course->progress = $progress;

        return $this->success(data: new CoursesDetailResource($course), code: Response::HTTP_OK);
       
    }

    public function updateProgress(Request $request){
        
        $response = isDemoSite();
        if( $response ){
            return $this->error(message:  __('general.demosite_res_title'), code: Response::HTTP_FORBIDDEN);
        }
        
        if(auth()->user()?->role != 'student'){
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }

        $course = $this->courseService->getCourse(
            courseId: $request->course_id,
            relations: [
                'promotionalVideo',
                'sections' => function ($query) use ($request) {
                    $query->withWhereHas('curriculums', function ($subQuery) use ($request) {
                        $subQuery->where('id', $request->curriculum_id);
                        $subQuery->whereNotNull('media_path')->orWhereNotNull('article_content');
                        $subQuery->with('watchtime');
                        $subQuery->orderBy('sort_order', 'asc');
                    });
                },
            ],
        );
   
        if (empty($course)) {
            return $this->error(message: __('courses::courses.course_not_found'), code: Response::HTTP_NOT_FOUND);
        }
       
        $firstCurriculum = $course?->sections?->first()?->curriculums?->first();

        if ($firstCurriculum) {
            $activeCurriculum = $firstCurriculum->toArray();
        }
  
        $curriculumId   = (int)$activeCurriculum['id'] ?? 0;
        $sectionId      = (int) $activeCurriculum['section_id'] ?? 0;
        $totalDuration  = (int) $activeCurriculum['content_length'] ?? 0;

        $watchtime  = (new CurriculumService())->getWatchtime($curriculumId, $sectionId);
        if ($watchtime) {
            $duration = $watchtime->duration;
            if ($totalDuration == $duration)  {
               return $this->success(message: __('courses::courses.already_watched'), data: '', code: Response::HTTP_BAD_REQUEST);
            } else {
                (new CurriculumService())->updateWatchtime((int) $curriculumId, (int) $sectionId, (int) $totalDuration);
                return $this->success(message: __('courses::courses.update_progress_success'), data: '', code: Response::HTTP_OK);  
            }
        }
        (new CurriculumService())->addWatchtime((int) $request->course_id,(int) $curriculumId, (int) $sectionId, (int) $totalDuration);
        return $this->success(message: __('courses::courses.update_progress_success'), data: '', code: Response::HTTP_OK);
    }

    public function getCourseList(Request $request){
        
        if(auth()->user()?->role != 'student'){
            return $this->error(message: __('courses::courses.unauthorized_access'), code: Response::HTTP_FORBIDDEN);
        }

        $favCourseIds   = Like::where('likeable_type', Course::class)->where('user_id', Auth::id())?->pluck('likeable_id')?->toArray() ?? [];
        $perPage        = !empty($request->get('per_page')) ? $request->get('per_page') : 3;

        $courses = $this->courseService->getAllEnrolledCourses(
            keyword: $request->keyword,
            withSum: [
                'courseProgress' => 'duration'
            ],
            studentId: Auth::id(),
            perPage: $perPage
        );

        $courses->each(function ($course) use ($favCourseIds) {
            $course->is_favorite = in_array($course->id, $favCourseIds);
            
            if (!empty($course->course_progress_sum_duration) && !empty($course->course->content_length)) {
                $course->progress = floor(($course->course_progress_sum_duration / $course->course->content_length) * 100);
            } else {
                $course->progress = 0;
            }
        });
        return $this->success(data: new EnrolledcoursesCollection($courses), code: Response::HTTP_OK);
    }

    public function enrollFreeCourse(Request $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(message:  __('general.demosite_res_title'), code: Response::HTTP_FORBIDDEN);
        }

        if (!auth()?->user()?->role == 'student') {
            return $this->error(data: null,message: __('courses::courses.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        if(isPaidSystem()) {
            return $this->error(message:  __('courses::courses.course_enrolled_paid_error'), code: Response::HTTP_BAD_REQUEST);
        }

        $course = $this->courseService->getCourseBySlug($request->slug);

        if (empty($course)) {
            return $this->error(message: __('courses::courses.course_not_found'), code: Response::HTTP_NOT_FOUND);
        }

        $enrolled = (new CourseService())->getStudentCourse(
            courseId: $course->id, 
            studentId: Auth::id(),
            tutorId: $course->instructor_id
        );
        if ($enrolled) {
            return $this->error(message: __('courses::courses.course_already_enrolled'), code: Response::HTTP_BAD_REQUEST);
        }

        $response = (new BookingService(Auth::user()))->enrollFreeCourse($course->id);

        if(empty($response['success'])) {
            return $this->error(data: null,message: __('general.went_wrong'),code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->success(message: __('courses::courses.course_enrolled_successfully'), code: Response::HTTP_OK);
    }
}   
