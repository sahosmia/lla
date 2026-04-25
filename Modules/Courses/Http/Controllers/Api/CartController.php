<?php

namespace Modules\Courses\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Modules\Courses\Services\CourseService;
use App\Http\Controllers\Controller;
use Modules\Courses\Models\Course;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Facades\Cart;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    use ApiResponser;

    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function store(Request $request)
    {
        $response = isDemoSite();
        if( $response ){
            return $this->error(message:  __('general.demosite_res_title'), code: Response::HTTP_FORBIDDEN);
        }

        if (!auth()?->user()?->role == 'student') {
            return $this->error(data: null,message: __('courses::courses.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

        $course = $this->courseService->getCourseBySlug($request->slug);

        if (!$course) {
            return $this->error(data: null,message: __('courses::courses.course_not_found'),code: Response::HTTP_NOT_FOUND);
        }
        
        if($course?->instructor_id == auth()->user()->id){
            return $this->error(data: null,message: __('courses::courses.unauthorized_access'),code: Response::HTTP_FORBIDDEN);
        }

       

        $data = [
            'id'                => $course?->id ?? null,
            'title'             => $course?->title ?? null,
            'price'             => $course?->pricing?->final_price ?? 0,
            'category'          => $course?->category?->name ?? null,
            'sub_category'      => $course?->subCategory?->name ?? null,
            'slug'              => $course?->slug ?? null,
            'image'             => $course?->thumbnail?->path ?? null,
        ];

        $cartItem = Cart::add(
            cartableId      : $data['id'],
            cartableType    : Course::class,
            name            : $data['title'],
            qty             : 1,
            price           : $course?->pricing?->final_price ?? 0,
            options         : $data
        );

        return $this->success(data: [
            'cartItem'  => new CartResource($cartItem),
            'total'     => formatAmount(Cart::total()),
            'subtotal'  => formatAmount(Cart::subtotal())
        ], message: __('courses::courses.added_to_cart'));

    }
}
