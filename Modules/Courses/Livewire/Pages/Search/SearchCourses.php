<?php

namespace Modules\Courses\Livewire\Pages\Search;

use Modules\Courses\Models\Category;
use Modules\Courses\Models\Course;
use Modules\Courses\Services\CourseService;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SearchCourses extends Component
{
    use WithPagination;

    public $isLoading = true;
    public $showClearFilters = false;

    public $perPage;
    public $languages;
    public $levels;
    public $categories;
    public $totalCourses;
    public $paidCourses;
    #[Url]
    public $tutor_id;
    public $user;
    #[Url]
    public $searchCategories    = [];
    #[Url]
    public $searchLanguages     = [];

    public $ratingCounts        = [];
    public $durationCounts      = [];
    public $priceTypeCounts     = [];
    public $currentVideo = null;
    public $parPageList = [9, 20, 30, 50, 100, 200];

    #[Url]
    public $filters     = [
        'keyword'           => '',
        'category'          => '',
        'levels'            => [],
        'languages'         => [],
        'per_page'          => '',
        'min_price'         => null,
        'max_price'         => null,
        'sort'              => 'desc',
        'avg_rating'        => [],
        'duration'          => [],
    ];


    public function mount()
    {
        if(!empty($this->tutor_id)){
            $this->user = (new CourseService())->getUser($this->tutor_id);
        }
        $this->isLoading            = true;
        $this->showClearFilters     = false;
        $this->perPage              = 9;


        $this->categories   = (new CourseService())->getCategories();
        $this->levels       = (new CourseService())->getLevels();
        $this->languages    = (new CourseService())->getLanguages();
        
        $ratingCounts = (new CourseService())->getCourseByRating()
            ->pluck('average_rating')
            ->filter(function ($value) {
                return !is_null($value);
            })
            ->countBy()
            ->sortDesc()
            ->toArray();

        foreach ([5, 4, 3, 2, 1] as $rating) {
            $this->ratingCounts[$rating] = $ratingCounts[$rating] ?? 0;
        }


        $durationCounts = (new CourseService())->getCourseByContentLength()
            ->pluck('course_count', 'duration_range')
            ->toArray();

        foreach (['0-1', '1-3', '3-6', '6-17', '17+'] as $range) {
            if (isset($durationCounts[$range])) {
                $this->durationCounts[$range] = $durationCounts[$range];
            } else {
                $this->durationCounts[$range] = 0;
            }
        }

        $this->toggleShowClearFilters();
    }
    
    public function closeTutorDetail()
    {
        $this->tutor_id = null;
        $this->dispatch('closeTutorDetail');

    }

    public function toggleShowClearFilters()
    {
        if (!empty($this->filters['keyword']) || 
            !empty($this->filters['levels']) ||
            !empty($this->filters['languages']) ||
            !empty($this->filters['per_page']) ||
            !is_null($this->filters['min_price']) ||
            !is_null($this->filters['max_price']) ||
            $this->filters['sort'] !== 'desc' ||
            !empty($this->filters['avg_rating']) ||
            !empty($this->filters['duration']) ||
            !empty($this->searchCategories) ||
            !empty($this->searchLanguages)
        ) {
            $this->showClearFilters = true;
        } else {
            $this->showClearFilters = false;
        }
        $this->resetPage();
    }

    public function render()
    {
        $courses = (new CourseService())->getCourses(
            instructorId: !empty($this->tutor_id) ? $this->tutor_id : null,
            with: [
                'category',
                'pricing',
                'language',
                'promotionalVideo',
                'instructor',
                'instructor.profile',
                'likes',
                'thumbnail',
            ],
            withCount: ['ratings', 'curriculums'],
            withAvg: [
                'ratings' => 'rating',
            ],
            filters: array_merge($this->filters, ['categories' => $this->searchCategories, 'languages' => $this->searchLanguages, 'status' => 'active',]),
            perPage: $this->perPage
        );

        $courses->each(function ($course) {
            $course->like_user_ids = $course->likes->pluck('user_id');
        });

        $this->totalCourses = (new CourseService())->getAllCourses(filters: ['status' => 'active'])->count();
        $this->paidCourses  = (new CourseService())->getPaidCourses()->count();



        return view('courses::livewire.search.search-courses', [
            'courses' => $courses,
        ])->extends('layouts.frontend-app', [
            'pageTitle' => 'Search Courses'
        ]);
    }

    public function updateFiltersAvgRating($rating)
    {
        if (in_array($rating, $this->filters['avg_rating'])) {
            $this->filters['avg_rating'] = array_diff($this->filters['avg_rating'], [$rating]);
        } else {
            $this->filters['avg_rating'][] = $rating;
        }
        $this->toggleShowClearFilters();
    }

    public function updateFiltersDuration($duration)
    {
        if (in_array($duration, $this->filters['duration'])) {
            $this->filters['duration'] = array_diff($this->filters['duration'], [$duration]);
        } else {
            $this->filters['duration'][] = $duration;
        }
        $this->toggleShowClearFilters();
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->toggleShowClearFilters();
        $this->resetPage();
    }

    public function updatedSearchCategories()
    {
        $this->toggleShowClearFilters();
        $this->resetPage();
    }

    public function updatedSearchLanguages()
    {
        $this->toggleShowClearFilters();
        $this->resetPage();
    }

    public function resetFilters()
    {


        $this->filters = [
            'keyword'       => '',
            'category'      => '',
            'levels'        => [],
            'languages'     => [],
            'per_page'      => '',
            'min_price'     => null,
            'max_price'     => null,
            'sort'          => 'desc',
            'avg_rating'    => [],
            'duration'      => [],
        ];

        $this->searchLanguages  = [];
        $this->searchCategories = [];

        $this->showClearFilters = false;
        $this->resetPage();
        $this->dispatch('resetFilters');
    }

    public function isLiked($course)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        return $course->likes()->where('user_id', Auth::id())->exists();
    }

    public function likeCourse($courseId)
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        if (!Auth::check()) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('courses::courses.login_to_like_a_course'));
            return;
        }

        $course = (new CourseService())->getCourse($courseId);

        if ($this->isLiked($course)) {
            $course->likes()->where('user_id', Auth::id())->delete();
        } else {
            $course->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function loadData()
    {
        $this->isLoading = false;
        $this->dispatch('initSelect2', target: '.am-select2', time: 0);
        $this->dispatch('loadPageJs');
    }
}
