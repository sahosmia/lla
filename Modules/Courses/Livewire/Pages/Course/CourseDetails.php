<?php

namespace Modules\Courses\Livewire\Pages\Course;

use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use App\Facades\Cart;
use App\Models\Rating;
use App\Models\User;
use App\Services\BookingService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CourseDetails extends Component
{
    use WithPagination;

    public $isLoading = true;

    public $slug;
    public $instructorCoursesCount;
    public $fullDescription = false;
    public $instructorReviewsCount;
    public $instructorAvgReviews;
    public $isBuyable = true;
    public $viewCourse = false;
    public $role = null;
    public $backRoute = null;
    public $courseInCart = 0;
    public $cartItems = [];

    private OrderService $orderService;

    public $socialIcons = [
        'Facebook'      => 'am-icon-facebook-1',
        'X/Twitter'     => 'am-icon-twitter-02',
        'LinkedIn'      => 'am-icon-linkedin-02',
        'Instagram'     => 'am-icon-instagram',
        'Pinterest'     => 'am-icon-pinterest',
        'YouTube'       => 'am-icon-youtube',
        'TikTok'        => 'am-icon-tiktok-02',
        'WhatsApp'      => 'am-icon-whatsapp',
    ];

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $this->slug = request()->slug;
        $this->role = auth()?->user()?->role;

        if (!$this->course) {
            abort(404);
        }

        if (
            (!Auth::check() && $this->course->status != 'active') ||  (!auth()?->user()?->hasRole('admin') &&
                $this->course->instructor_id != Auth::id() &&
                $this->course->status != 'active')
        ) {
            abort(404);
        }
        $this->instructorCoursesCount   = (new CourseService())->getInstructorCoursesCount($this->course->instructor_id);
        $this->instructorReviewsCount   = Rating::where('ratingable_type', User::class)->where('ratingable_id', $this->course->instructor_id)->count();
        $this->instructorAvgReviews     = Rating::where('ratingable_type', User::class)->where('ratingable_id', $this->course->instructor_id)->avg('rating');
        if ($this->role == 'admin' || $this->course->instructor_id == Auth::id()) {
            $this->viewCourse = true;
        } elseif ($this->role == 'student') {
            $courseAddedToStudent = (new CourseService())->getStudentCourse(
                courseId: $this->course->id,
                studentId: Auth::id(),
                tutorId: $this->course->instructor_id
            );
            $this->viewCourse = !empty($courseAddedToStudent);
            $this->isBuyable = !$courseAddedToStudent;
        }

        if (!auth()?->user()?->hasRole('admin')) {
            $this->manageViews($this->course);
        }
    }

    #[Computed(persist: true)]
    public function course()
    {
        return (new CourseService())->getCourse(
            slug: $this->slug,
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
                'promotionalVideo',
                'pricing',
                'sections' => function ($query) {
                    $query->withWhereHas('curriculums', function ($subQuery) {
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
                'instructor as active_students_count' => function ($query) {  // Count total enrollments
                    $query->withCount('courses')
                        ->join(config('courses.db_prefix') . 'courses', 'users.id', '=', config('courses.db_prefix') . 'courses.instructor_id')
                        ->join(config('courses.db_prefix') . 'enrollments', config('courses.db_prefix') . 'courses.id', '=', config('courses.db_prefix') . 'enrollments.course_id');
                },

            ],
            status: null
        );
    }

    #[Computed]
    public function totalArticles()
    {
        $count = 0;
        foreach ($this->course->sections as $section) {
            $count += count($section->curriculums->where('type', 'article'));
        }
        return $count;
    }

    #[Computed]
    public function totalVideos()
    {
        $count = 0;
        foreach ($this->course->sections as $section) {
            $count += count($section->curriculums->where('type', 'video'));
        }
        return $count;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $course = $this->course;
        $totalArticles = $this->totalArticles;
        $totalVideos = $this->totalVideos;
        $cartItems = Cart::content();
        $this->courseInCart = $cartItems->where('cartable_type', Course::class)->where('cartable_id', $this->course->id)->count();
        $courseInCart = $this->courseInCart;
        $og_tags = [
            'og:title' => $this->course->title,
            'og:description' => $this->course->description,
            'og:image' => $this->course->thumbnail?->path ? Storage::url($this->course->thumbnail?->path) : asset('modules/courses/images/logo.svg'),
            'og:url' =>  route('courses.course-detail', ['slug' => $this->course->slug]),
            'og:type' => 'website',
            'og:site_name' => setting('_general.site_name'),
            'og:locale' => 'en_US',
            'og:author' => $this->course->instructor->profile->full_name,
            'og:publisher' => $this->course->instructor->profile->full_name,
            'og:updated_time' => $this->course->updated_at,
            'og:creator' => $this->course->instructor->profile->full_name,
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->course->title,
            'twitter:description' => $this->course->description,
            'twitter:image' => $this->course->thumbnail?->path ? Storage::url($this->course->thumbnail?->path) : asset('modules/courses/images/logo.svg'),
            'twitter:site' => '@' . setting('_general.site_name'),
            'twitter:creator' => '@' . $this->course->instructor->profile->full_name
        ];
        return view('courses::livewire.course.course-detail', compact('course', 'totalArticles', 'totalVideos', 'courseInCart'))->extends('layouts.frontend-app', ['pageTitle' => $course->title, 'pageDescription' => $course->description, 'metaImage' => $this->course->thumbnail?->path ? Storage::url($this->course->thumbnail?->path) : asset('module/courses/images/logo.svg'), 'og_tags' => $og_tags]);
    }

    public function toggleDescription()
    {
        $this->fullDescription = !$this->fullDescription;
    }

    protected function manageViews($course)
    {
        $courseSessionKey = 'course_viewed_' . $course->id;

        if (!request()->session()->has($courseSessionKey)) {
            $course->increment('views_count');
            request()->session()->put($courseSessionKey, true, 1440);
        }
    }

    public function addStudentCourse()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!auth()?->check()) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.login_required')
            );
            return;
        }

        if (!auth()?->user()?->role == 'student') {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.not_allowed')
            );
            return;
        }

        $isAdded = (new CourseService())->addStudentCourse(Auth::id(), $this->course->id);

        if (!$isAdded) {
            return;
        }

        $this->dispatch(
            'showAlertMessage',
            type: 'success',
            message: __('courses::courses.course_added_to_student_courses')
        );

        return redirect()->route('courses.course-taking', ['slug' => $this->course->slug]);
    }

    public function addToCart()
    {
        if (!auth()?->check()) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.login_required')
            );
            return;
        }

        if (!auth()?->user()?->role == 'student') {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.only_student_can_add_to_cart')
            );
            return;
        }

        $data = [
            'id' => $this->course->id,
            'title' => $this->course->title,
            'price' => $this->course?->pricing?->final_price ?? 0,
            'category' => $this->course->category->name,
            'sub_category' => $this->course->subCategory->name,
            'slug' => $this->course->slug,
            'image' => $this->course->thumbnail?->path,
        ];
        Cart::add(
            cartableId: $data['id'],
            cartableType: Course::class,
            name: $data['title'],
            qty: 1,
            price: $this->course?->pricing?->final_price ?? 0,
            options: $data
        );
        $this->dispatch('cart-updated', cart_data: Cart::content(), discount: formatAmount(Cart::discount(), true), total: formatAmount(Cart::total(), true), subTotal: formatAmount(Cart::subtotal(), true), toggle_cart: 'open');
    }


    public function enrollCourse()
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (!auth()?->check()) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.login_required')
            );
            return;
        }

        if (!auth()?->user()?->role == 'student') {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __('courses::courses.not_allowed')
            );
            return;
        }
        $response = (new BookingService(Auth::user()))->enrollFreeCourse($this->course->id);

        if (empty($response['success'])) {
            return $this->dispatch(
                'showAlertMessage',
                type: 'error',
                message: __($response['message'])
            );
        }

        return redirect()->route('courses.course-list');
    }

    #[On('remove-course-cart')]
    public function removeCourseCart($params)
    {
        Cart::remove($params['cartable_id'], $params['cartable_type']);
        $this->courseInCart = Cart::content()->where('cartable_type', Course::class)->where('cartable_id', $this->course->id)->count();
        $this->orderService->deleteOrderItem($params['cartable_id'], $params['cartable_type']);
        $this->reset(['courseInCart']);
    }
}
