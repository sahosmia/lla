<?php

namespace Modules\Courses\Services;

use Modules\Courses\Models\Course;
use Modules\Courses\Models\Curriculum;
use Modules\Courses\Models\DiscussionForum;
use Modules\Courses\Models\Enrollment;
use Modules\Courses\Models\Like;
use App\Models\User;
use Modules\Courses\Models\Noticeboard;
use Modules\Courses\Models\Promotion;
use App\Models\Language;
use Modules\Courses\Models\Section;
use App\Casts\OrderStatusCast;
use App\Models\OrderItem;
use Modules\Courses\Models\Category;

use Illuminate\Support\Facades\Auth;

class CourseService
{

    /**
     * Get course
     *
     * @param int|null $courseId
     * @param string|null $slug
     * @param int|null $instructorId
     * @param array $relations
     * @param array $withSum
     * @return Course|null
     */
    public function getCourse(int $courseId = null, string $slug = null, int $instructorId = null, $relations = [], $withAvg = [], $status = null, $withCount = [], $withSum = [])
    {

        if (empty($courseId) && empty($slug)) {
            return null;
        }

        $query =  Course::with($relations)

        ->when($instructorId, function ($query, $instructorId) {
            return $query->where('instructor_id', $instructorId);
        })

        ->when($slug, function ($query, $slug) {
            return $query->where('slug', $slug);
        })

        ->when($courseId, function ($query, $courseId) {
            return $query->where('id', $courseId);
        })

        ->when($status, function ($query, $status) {
            return $query->where('status', Course::STATUSES[$status]);
        })

        ->withCount($withCount);

        if (!empty($withAvg) && is_array($withAvg)) {
            foreach ($withAvg as $relationship => $column) {
                $query->withAvg($relationship, $column);
            }
        }

        if (!empty($withSum) && is_array($withSum)) {
            foreach ($withSum as $relationship => $column) {
                $query->withSum($relationship, $column);
            }
        }

        return $query->first();
    }

    public function getInstructorCourses($instructorId, $status = [], $select = [])
    {
        return Course::where('instructor_id', $instructorId)
        ->when(!empty($status), fn($query) => $query->whereIn('status', array_map(fn($status) => Course::STATUSES[$status], $status)))
        ->when(!empty($select), fn($query) => $query->select($select))
        ->get();
    }

    public function getAllEnrolledCourses($studentId,  $withSum = [], $keyword = null, $perPage = 10)
    {
        $dataQuery = Enrollment::where('student_id', $studentId)->with('courseProgress')->withWhereHas('course', function($query) use ($keyword) {
            $query->select('id', 'title', 'slug', 'instructor_id', 'category_id', 'sub_category_id', 'content_length');
            $query->with([
                'category',
                'promotionalVideo',
                'instructor.profile:id,user_id,first_name,last_name,image,slug',
                'thumbnail',
            ]);
            $query->when(!empty($keyword), fn($subQuery) => $subQuery->where('title', 'like', '%' . $keyword . '%'));
         })
         ->when(
            !empty($withSum),
            function ($query) use ($withSum, $studentId) {
                foreach ($withSum as $relation => $column) {
                    $query->withSum([
                        $relation => function($query) use ($studentId) { 
                            $query->where('user_id', $studentId);
                        }
                    ], $column);
                }
        });

        return $dataQuery->paginate($perPage);
    }

    /**
     * Get student course
     *
     * @param int $courseId
     * @return Enrollment|null
     */
    public function getStudentCourse($courseId, $studentId = null, $tutorId = null)
    {
        return Enrollment::where('course_id', $courseId)
        ->when($studentId, function ($query, $studentId) {
            return $query->where('student_id', $studentId);
        })
        ->when($tutorId, function ($query, $tutorId) {
            return $query->where('tutor_id', $tutorId);
        })
        ->first();
    }

    /**
     * Delete a course by ID.
     *
     * @param int $courseId
     * @return bool|null
     * @throws \Exception
     */
    public function deleteCurriculum(int $curriculumId)
    {
        $curriculum = Curriculum::find($curriculumId);
        if ($curriculum) {
            return $curriculum->delete();
        }
        return false;
    }

    /**
     * Update or create a noticeboard.
     *
     * @param array $data
     * @return Noticeboard
     */
    public function updateCourseNoticeboard(array $data)
    {
        $noticeboard = Noticeboard::updateOrCreate(['id' => $data['id']], $data);
        return $noticeboard;
    }

    public function deleteNoticeboard($noticeboardId)
    {
        $noticeboard = Noticeboard::find($noticeboardId);
        if ($noticeboard) {
            return $noticeboard->delete();
        }
        return false;
    }

    public function getNoticeboardById($noticeboardId, $courseId)
    {
        return Noticeboard::where('id', $noticeboardId)->whereCourseId($courseId)->first();
    }

    /**
     * Delete a course by ID.
     *
     * @param int $curriculumId
     * @param array $data
     * @return Curriculum
     * @throws \Exception
     */
    public function updateCurriculum(int $curriculumId, array $data)
    {
        $curriculum = Curriculum::findOrFail($curriculumId);
        $curriculum->update($data);
        return $curriculum;
    }

    /**
     * Get a curriculum by ID.
     *
     * @param int $curriculumId
     * @return Curriculum
     * @throws \Exception
     */
    public function getCurriculumById(int $curriculumId)
    {
        $curriculum = Curriculum::find($curriculumId);
        if($curriculum) {
            return $curriculum;
        }
        return false;
    }

    /* Crate or update course.
     *
     * @param int|null $courseId
     * @param array $data
     * @return Course
     */
    public function updateOrCreateCourse(?int $courseId, array $data)
    {
        $course = Course::updateOrCreate(
            ['id' => $courseId],
            $data
        );

        return $course;
    }

    /**
     * Create a new section.
     *
     * @param array $data
     * @return Section
     */
    public function createSection(array $data)
    {
        $isCreated = Section::create($data);
        if ($isCreated) {
            return $isCreated;
        }
        return false;
    }

    /**
     * Update an existing section.
     *
     * @param int $id
     * @param array $data
     * @return Section
     */
    public function updateSection(int $id, array $data)
    {
        $section = Section::findOrFail($id);
        $section->update($data);
        return $section;
    }

    /**
     * Get a section by ID.
     *
     * @param int $id
     * @return Section
     */
    public function getSectionById(int $id)
    {
        return Section::findOrFail($id);
    }

    /**
     * Delete a section by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSection(int $id)
    {
        $section = Section::find($id);
        if ($section) {
            return $section->delete();
        }
        return false;
    }

    /**
     * Get all sections with pagination.
     *
     * @param int $perPage
     * @param int $courseId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllSections(int $courseId, int $perPage = 15)
    {
        // Use Livewire pagination
        return Section::where('course_id', $courseId)->paginate($perPage);
    }


    public function updateCoursePricing($course, $data)
    {
        $course->pricing()->updateOrCreate(['course_id' => $course->id], $data);
        return $course;
    }

    public function addCourseFaq($course, $faq)
    {
        $course->faqs()->create($faq);
        return $course;
    }

    public function updateCourseFaq($course, $faqId, $faq)
    {
        $course->faqs()->where('id', $faqId)->update($faq);
        return $course;
    }

    public function updatePrerequisites($courseId, $prerequisites)
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->prerequisites = $prerequisites;
            $course->save();
            return $course;
        }
    }

    public function deleteFaq($course, $faqId): bool
    {
        $faq = $course->faqs()->whereId($faqId)->first();
        if ($faq) {
            $faq->delete();
            return true;
        } else {
            return false;
        }
    }

    public function addCoursePromotion($course, $promotion)
    {
        $course->promotions()->create($promotion);
        return $course;
    }

    public function updateCoursePromotion($course, $promotion)
    {
        $course->promotions()->where('id', $promotion['id'])->update($promotion);
        return $course;
    }

    public function getPromotionById($promotionId)
    {
        return Promotion::findOrFail($promotionId);
    }

    public function deletePromotion($course, $promotionId): bool
    {
        $promotion = $course->promotions()->whereId($promotionId)->first();
        if ($promotion) {
            $promotion->delete();
            return true;
        } else {
            return false;
        }
    }

    public function addCourseMedia(Course $course, array $condition = [], array $media)
    {
        $course->media()->updateOrCreate($condition, $media);
        return $course;
    }

    /**
     * Build the course query.
     *
     * @param int|null $instructorId
     * @param array $with
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    /**
     * Build the course query with applied filters, relationships, and aggregations.
     *
     * @param int|null $instructorId
     * @param array $with
     * @param array $filters
     * @param array $withCount
     * @param array $withAvg
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function buildCourseQuery(int $instructorId = null, $with = [], $filters = [], $withCount = [], $withAvg = [])
    {
    
        $query = Course::query()
            ->whereNull('deleted_at')
            // Filter by instructor ID if provided
            ->when($instructorId, fn($query) => $query->where('instructor_id', $instructorId))
            
            // Apply various filters
            ->when(!empty($filters['featured']), fn($query) => $query->where('featured', 1))
            ->when(!empty($filters['keyword']), fn($query) => $query->where('title', 'like', '%' . $filters['keyword'] . '%'))
            ->when(!empty($filters['category_id']), fn($query) => $query->where('category_id', $filters['category_id']))
            ->when(!empty($filters['categories']), fn($query) => $query->whereIn('category_id', $filters['categories']))
            ->when(!empty($filters['levels']), fn($query) => 
                $query->whereIn('level', array_map(fn($level) => Course::LEVEL[$level], $filters['levels']))
            )
            ->when(!empty($filters['status']), fn($query) => $query->where('status', Course::STATUSES[$filters['status']]))
            ->when(!empty($filters['statuses']), fn($query) => 
                $query->whereIn('status', array_map(fn($status) => Course::STATUSES[$status], $filters['statuses']))
            )
            ->when(!empty($filters['languages']), fn($query) => $query->whereIn('language_id', $filters['languages']))
            ->when(!empty($filters['min_price']), fn($query) => 
                $query->whereHas('pricing', fn($q) => $q->where('final_price', '>=', $filters['min_price']))
            )
            ->when(!empty($filters['max_price']), fn($query) => 
                $query->whereHas('pricing', fn($q) => $q->where('final_price', '<=', $filters['max_price']))
            )
            ->when(!empty($filters['pricing_type']) && $filters['pricing_type'] === 'paid', fn($query) => 
                $query->whereHas('pricing', fn($q) => $q->where('final_price', '>', 0))
            )
            
            // Apply duration filters
            ->when(!empty($filters['duration']), function ($query) use ($filters) {
                $query->where(function ($subQuery) use ($filters) {
                    foreach ($filters['duration'] as $index => $range) {
                        $subQuery->when($index === 0, function ($query) use ($range) {
                            switch ($range) {
                                case '0-1':
                                    $query->whereBetween('content_length', [0, 1 * 3600]);
                                    break;
                                case '1-3':
                                    $query->whereBetween('content_length', [1 * 3600, 3 * 3600]);
                                    break;
                                case '3-6':
                                    $query->whereBetween('content_length', [3 * 3600, 6 * 3600]);
                                    break;
                                case '6-17':
                                    $query->whereBetween('content_length', [6 * 3600, 17 * 3600]);
                                    break;
                                case '17+':
                                    $query->where('content_length', '>=', 17 * 3600);
                                    break;
                            }
                        }, function ($query) use ($range) {
                            switch ($range) {
                                case '0-1':
                                    $query->orWhereBetween('content_length', [0, 1 * 3600]);
                                    break;
                                case '1-3':
                                    $query->orWhereBetween('content_length', [1 * 3600, 3 * 3600]);
                                    break;
                                case '3-6':
                                    $query->orWhereBetween('content_length', [3 * 3600, 6 * 3600]);
                                    break;
                                case '6-17':
                                    $query->orWhereBetween('content_length', [6 * 3600, 17 * 3600]);
                                    break;
                                case '17+':
                                    $query->orWhere('content_length', '>=', 17 * 3600);
                                    break;
                            }
                        });
                    }
                });
            })
            
            // Eager load relationships
            ->with($with)
            ->withCount($withCount)
            
            // Apply additional average calculations if provided
            ->when(!empty($withAvg) && is_array($withAvg), function ($query) use ($withAvg) {
                foreach ($withAvg as $relationship => $column) {
                    $query->withAvg($relationship, $column);
                }
            })
            
            // Apply sorting
            ->when(!empty($filters['sort']), function ($query) use ($filters) {
                $query->orderBy('created_at', $filters['sort']);
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            });

        // Apply average rating filter using having on the aggregated average
        if (!empty($filters['avg_rating']) && is_array($filters['avg_rating'])) {
            // Use havingRaw to filter based on the floored average rating
            $avgRatings = implode(',', array_map('intval', $filters['avg_rating']));
            $query->havingRaw("FLOOR(ratings_avg_rating) IN ($avgRatings)");
        }

        return $query;
    }


    /**
     * Get all courses
     *
     * @param int|null $instructorId
     * @param array $filters
     * @param array $with
     * @param array $withCount
     * @param array $withAvg
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCourses($instructorId = null, $with = [], $filters = [], $withCount = [], $withAvg = [])
    {
        return $this->buildCourseQuery($instructorId, $with, $filters, $withCount, $withAvg)->get();
    }

    /**
     * Get all courses with pagination.
     *
     * @param int $perPage
     * @param int|null $instructorId
     * @param array $filters
     * @param array $with
     * @param array $withCount
     * @param array $withAvg
     * @param string|null $searchKeyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCourses(int $instructorId = null, $with = [], array $filters = [], $withCount = [], $withAvg = [],  $perPage = null)
    {
        return $this->buildCourseQuery($instructorId, $with, $filters, $withCount, $withAvg)->paginate($perPage ?? 10);
    }

    /**
     * Like a course.
     *
     * @param int $courseId
     * @param int $userId
     * @return bool
     */
    public function likeCourse(int $courseId, int $userId): bool
    {
        $course = Course::find($courseId);

        if (!$course) {
            return false;
        }

        $like = new Like();
        $like->user_id = $userId;
        $course->likes()->save($like);

        return true;
    }

    /**
     * Get the count of active courses grouped by their content length.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCourseByContentLength()
    {
        return Course::where('status', Course::STATUSES['active'])->selectRaw('CASE
        WHEN content_length >= 0 AND content_length <= 1 * 3600 THEN "0-1"
        WHEN content_length >= 1 * 3600 AND content_length <= 3 * 3600 THEN "1-3"
        WHEN content_length >= 3 * 3600 AND content_length <= 6 * 3600 THEN "3-6"
        WHEN content_length >= 6 * 3600 AND content_length <= 17 * 3600 THEN "6-17"
        ELSE "17+"
        END AS duration_range, COUNT(*) as course_count')
            ->groupBy('duration_range')
            ->get();
    }

    /**
     * Get the count of active courses grouped by their average rating.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCourseByRating()
    {
        return Course::where('status', Course::STATUSES['active'])
            ->join('ratings', function ($join) {
                $join->on(config('courses.db_prefix') . 'courses.id', '=', 'ratings.ratingable_id')
                    ->where('ratings.ratingable_type', '=', 'course');
            })
            ->groupBy(config('courses.db_prefix') . 'courses.id')
            ->selectRaw('FLOOR(AVG(ratings.rating)) as average_rating');
    }

    public function addCourseRating($id, $rating)
    {
        $course = Course::find($id);
        if ($course) {
            $course->ratings()->create([
                'student_id' => Auth::id(),
                'tutor_id'   => $course->instructor_id,
                'rating'     => $rating['rating'],
                'comment'     => $rating['description'],
            ]);
            return $course;
        }
        return false;
    }
    /**
     * Get all paid courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPaidCourses()
    {
        return Course::whereHas('pricing', function ($query) {
            $query->where('final_price', '>', 0.00);
        })->get();
    }

    public function getInstructorCoursesCount($instructorId)
    {
        return Course::whereInstructorId($instructorId)->whereStatus(Course::STATUSES['active'])->count();
    }

    /**
     * Update the status of a course.
     *
     * @param int $courseId
     * @param string $status
     * @return bool
     */
    public function updateCourseStatus($courseId, $status)
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->status = $status;
            $course->save();
            return true;
        }
        return false;
    }

    /**
     * Update the content length of a course.       
     *
     * @param Modules\Courses\Models\Course $course
     * @return bool
     */
    public function updateCourseContentLength($course)
    {
        $totalContentLength = $course->sections->sum(function ($section) {
            return $section->curriculums->sum('content_length');
        });

        if ($totalContentLength > 0) {
            $course->content_length    = $totalContentLength;
            $course->save();
        }
    }

    public function addStudentCourse($courseData = [])
    {
        $isAdded = Enrollment::firstOrCreate(['student_id' => $courseData['student_id'], 'course_id' => $courseData['course_id']], $courseData);
        if ($isAdded) {
            return true;
        }
        return false;
    }

    public function addCommentToForum($data)
    {
        $discussionForum = DiscussionForum::create($data);
        return $discussionForum;
    }

    public function getCommentsByCourseId($courseId)
    {
        return DiscussionForum::where('course_id', $courseId)->whereNull('parent_id')->with(['likes','replies'])->withCount('likes')->get();
    }

    public function updateLikeComment($commentId)
    {
        $comment = DiscussionForum::find($commentId);
        $existingLike = $comment->likes()->where('user_id', Auth::user()->id)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            $comment->likes()->create([ 
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function deleteCourse($courseId){
        $course = Course::find($courseId);
        if($course){
            $course->delete();
            return true;
        }
        return false;
    }

    public function getCourseEnrollments($search, $status, $sortby)
    {
        $orders = OrderItem::withWhereHas('orders', function($query) use ($status) {
            $query->select('id', 'status', 'transaction_id', 'user_id')->with('userProfile');
            if (isset(OrderStatusCast::$statuses[$status])) {
                $query->whereStatus(OrderStatusCast::$statuses[$status]);
            }
        })->whereHasMorph('orderable', [Course::class])
        ->with('orderable');


        if (!empty($search)) {
            $orders->where('title','like','%'.$search.'%');
        }

        $orders = $orders->orderBy('id', $sortby ?? 'asc')
            ->paginate(setting('_general.per_page_opt') ?? 10);

        return $orders;
    }

    public function getFeaturedCourses($userId)
    {
        return Course::where('instructor_id', $userId)->where('featured', 1)
            ->with([
                'category',
                'pricing',
                'language',
                'promotionalVideo',
                'instructor',
                'instructor.profile',
                'likes',
                'thumbnail',
            ])->get();
    }

    public function getUser($userId)
    {
        $user = User::where('id', $userId)
            ->with(['profile:id,user_id,slug,first_name,last_name,image,native_language',
                    'address:id,addressable_id,addressable_type,country_id'])
            ->withAvg('reviews', 'rating')
            ->first();
        if($user){
            return $user;
        }
        return null;
    }

    public function courseEnrollments($id){
        return Course::with('enrollments')->find($id);
    }

    public function getCategories(){

        $categories           = Category::withCount('activeCourses')->whereParentId(null)->get();
        $categories           = $categories->sortBy(function ($category) {
            return strtolower($category->name);
        })->sortByDesc('active_courses_count')->values();
        return $categories;
    }

    public function getLevels(){

        $levels               = Course::LEVEL;
        $levelCounts = Course::selectRaw('level, COUNT(*) as course_count')
            ->where('status', Course::STATUSES['active'])
            ->groupBy('level')
            ->get();

        $levelCounts = $levelCounts->keyBy('level')->toArray();

        foreach ($levels as $key => $value) {
            $levels[$key] = [
                'id' => $value,
                'name' => $key,
                'courses_count' => $levelCounts[$key]['course_count'] ?? 0
            ];
        }

        return $levels;
    }

    public function getLanguages(){

        $languages    = Language::withCount('activeCourses')->whereStatus('active')->get();
        $languages    = $languages->sortByDesc('active_courses_count')->values();
        
        return $languages;
    }

    public function getCourseBySlug($slug){
        return Course::whereSlug($slug)->with(['pricing', 'category', 'subCategory','thumbnail'])->first();
    }

    public function getCourseProgress($courseId, $withSum = [], $studentId = null)
    {
        $query = Course::query()->where('id', $courseId);

        if ($studentId) {
            foreach ($withSum as $relation => $column) {
                if ($relation === 'courseWatchedtime') {
                    $query->withSum([
                        'courseWatchedtime' => function ($q) use ($studentId) {
                            $q->where('user_id', $studentId);
                        }
                    ], $column);
                } else {
                    $query->withSum($relation, $column);
                }
            }
        } else {
            foreach ($withSum as $relation => $column) {
                $query->withSum($relation, $column);
            }
        }

        return $query->first();
    }
}
