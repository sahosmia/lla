<?php

namespace Modules\Courses\Livewire\Pages\Student\CourseTaking;

use Modules\Courses\Services\CourseService;
use Modules\Courses\Services\CurriculumService;
use Modules\Assignments\Services\AssignemntsService;
use Modules\Quiz\Services\QuizService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use App\Jobs\SendNotificationJob;
use App\Jobs\SendDbNotificationJob;
use Illuminate\Support\Str;
use Modules\Assignments\Models\Assignment;
use Modules\Quiz\Models\Quiz;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;

class CourseTaking extends Component
{

    public $logo;
    public $activeCurriculum;
    public $instructorCoursesCount;
    public $slug;
    public $rating;
    public $description;
    public $isLoading = true;
    public $progress;
    public $studentRating;
    public $role;
    public $backRoute = null;
    public $curriculumOrder = [];
    public $nextCurriculumItem = [];
    public $socialIcons = [
        'Facebook' => 'am-icon-facebook-1',
        'X/Twitter' => 'am-icon-twitter-02',
        'LinkedIn' => 'am-icon-linkedin-02',
        'Instagram' => 'am-icon-instagram',
        'Pinterest' => 'am-icon-pinterest',
        'YouTube' => 'am-icon-youtube',
        'TikTok' => 'am-icon-tiktok-02',
        'WhatsApp' => 'am-icon-whatsapp',
    ];

    #[Url]
    public $redirect = 'courses-list';

    public function mount()
    {
        $this->slug = request()->route('slug');
        $this->role = Auth::user()->role;
        $logo = setting('_general.logo_white');
        $this->logo = !empty($logo[0]['path']) ? Storage::url($logo[0]['path']) : asset('modules/courses/images/logo.svg');

        if (!$this->course) {
            abort(404);
        }

        if ($this->role == 'tutor' && $this->course?->instructor_id != Auth::id()) {
            return $this->redirect(route('courses.course-detail', ['slug' => $this->course->slug]));
        }

        $courseAddedToStudent = (new CourseService())->getStudentCourse(
            courseId: $this->course->id,
            studentId: Auth::id(),
            tutorId: $this->course->instructor_id
        );

        if ($this->role == 'student' && !$courseAddedToStudent) {
            return $this->redirect(route('courses.search-courses'));
        }

        if (!empty($this->course->course_watchtime_sum_duration) && !empty($this->course->content_length)) {
            $progress = floor(($this->course->course_watchtime_sum_duration / $this->course->content_length) * 100);
            $this->progress = $progress >= 99 ? 100 : $progress;
        }

        $firstCurriculum = $this->course?->sections?->first()?->curriculums?->first();
        if ($firstCurriculum) {
            $this->activeCurriculum = $firstCurriculum->toArray();
            $this->setActiveCurriculmPath();
        }

        $this->studentRating = $this->course->ratings->where('student_id', Auth::id())->first();

        if ($this->role == 'student') {
            $this->backRoute = $this->redirect == 'courses-list' ? route('courses.course-list') : route('courses.course-detail', ['slug' => $this->course->slug]);
        }

        if ($this->role == 'admin') {
            $this->backRoute =  route('courses.admin.courses');
        }

        if ($this->course->instructor_id == Auth::id()) {
            $this->backRoute =  route('courses.tutor.courses');
        }

        // Build curriculum order array for navigation
        $allCurriculums = collect();
        foreach ($this->course->sections as $section) {
            $allCurriculums = $allCurriculums->concat($section->curriculums);
        }

        $sortedCurriculums = $allCurriculums->values();

        for ($i = 0; $i < $sortedCurriculums->count(); $i++) {
            $currentCurriculum = $sortedCurriculums[$i];
            $nextItem = $sortedCurriculums[$i + 1] ?? null;

            $this->curriculumOrder[$currentCurriculum->id] = $nextItem ? $nextItem->id : null;
            $this->nextCurriculumItem[$currentCurriculum->id] = !empty($nextItem) ? [
                'id' => $nextItem?->id,
                'title' => $nextItem?->title,
                'description' => $nextItem?->description,
                'type' => $nextItem?->type,
            ] : null;
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
                'courseWatchtime' => 'duration'  // Add this line to get sum of duration
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

    public function loadCourseData() {}

    public function render()
    {
        $totalVideos = $this->totalVideos;
        $this->instructorCoursesCount       = (new CourseService())->getInstructorCoursesCount($this->course->instructor_id);

        return view('courses::livewire.student.course-taking.course-taking', ['course' => $this->course, 'totalArticles' => $this->totalArticles, 'totalVideos' => $totalVideos])->extends('courses::layouts.app');
    }

    public function loadData()
    {
        $this->isLoading = false;
    }

    public function setActiveCurriculum($curriculum)
    {
        $this->activeCurriculum = $curriculum;
        $this->setActiveCurriculmPath();
    }

    public function nextCurriculum($id)
    {
        $nextCurriculum = (new CourseService())->getCurriculumById($id);

        if ($nextCurriculum) {
            $this->activeCurriculum = $nextCurriculum->toArray();
            $this->setActiveCurriculmPath();
        }
    }

    public function markAsCompleted()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $curriculumId = (int)$this->activeCurriculum['id'] ?? 0;
        $sectionId = (int) $this->activeCurriculum['section_id'] ?? 0;
        $totalDuration = (int) $this->activeCurriculum['content_length'] ?? 0;
        $watchtime = (new CurriculumService())->getWatchtime($curriculumId, $sectionId);
        if ($watchtime) {
            (new CurriculumService())->updateWatchtime((int) $curriculumId, (int) $sectionId, (int) $totalDuration);
        } else {
            (new CurriculumService())->addWatchtime((int) $this->course?->id, (int) $curriculumId, (int) $sectionId, (int) $totalDuration);
        }

        $courseDuration = (new CourseService())->getCourse(
            courseId: $this->course->id,
            withSum: [
                'courseWatchtime' => 'duration'
            ]
        );

        if (!empty($courseDuration->course_watchtime_sum_duration) && !empty($this->course->content_length)) {
            $this->progress = floor(($courseDuration->course_watchtime_sum_duration / $this->course->content_length) * 100);
        }

        $this->activeCurriculum['watchtime']['duration'] = $totalDuration;

        $this->dispatch('updated-progress', progress: $this->progress);
    }

    #[Renderless]
    public function updateWatchtime($isCompleted = false)
    {

        $response = isDemoSite();
        if ($response) {
            return;
        }

        $curriculumId = (int)$this->activeCurriculum['id'] ?? 0;
        $sectionId = (int) $this->activeCurriculum['section_id'] ?? 0;
        $totalDuration = (int) $this->activeCurriculum['content_length'] ?? 0;
        $isAssigned = false;
        $watchtime = (new CurriculumService())->getWatchtime($curriculumId, $sectionId);
        if ($watchtime) {
            $duration = $watchtime->duration;
            if ($isCompleted) {
                (new CurriculumService())->updateWatchtime((int) $curriculumId, (int) $sectionId, (int) $totalDuration);
            } else {
                if ($duration < $totalDuration) {
                    $updateDuration = $duration + 60 <= $totalDuration ? $duration + 60 : $totalDuration;
                    (new CurriculumService())->updateWatchtime((int) $curriculumId, (int) $sectionId, (int) $updateDuration);
                }
            }
        } else {

            if ($isCompleted) {
                $updateDuration = $totalDuration;
            } else {
                $updateDuration = $totalDuration > 60 ? 60 : $totalDuration;
            }

            (new CurriculumService())->addWatchtime((int) $this->course?->id, (int) $curriculumId, (int) $sectionId, (int) $updateDuration);
        }
        // Refresh course data to get updated watchtime values
        $courseDuration = (new CourseService())->getCourse(
            courseId: $this->course->id,
            withSum: [
                'courseWatchtime' => 'duration'
            ]
        );

        if (!empty($courseDuration->course_watchtime_sum_duration) && !empty($this->course->content_length)) {
            $this->progress = floor(($courseDuration->course_watchtime_sum_duration / $this->course->content_length) * 100);
        }

        if ($this->progress >= 100) {

            if (isActiveModule('upcertify')  && !empty($this->course?->certificate_id)) {
                $metaData = $this->course->meta_data ?? null;
                if (isActiveModule('Quiz')) {
                    if (!empty($metaData['assign_quiz_certificate']) && $metaData['assign_quiz_certificate'] == 'none') {
                        $this->generateCertificate();
                    }
                } else {
                    $this->generateCertificate();
                }
            }
            $isAssigned = $this->assignQuiz();
            $this->assignAssignment();
        }

        if ($isCompleted) {
            $this->nextCurriculum($this->activeCurriculum['id']);
        }

        $this->dispatch('updated-progress', progress: $this->progress, resultAssigned: $isAssigned);
    }

    public function assignQuiz()
    {
        $studentId = auth()->user()->id;
        $student = User::with('profile')->find($studentId);
        $isAssigned = false;
        if (isActiveModule('Quiz')) {
            $quizzes = $this->course?->quizzes;
            if (!empty($quizzes)) {

                foreach ($quizzes as $quiz) {
                    $isAlreadyAssigned = (new \Modules\Quiz\Services\QuizService())->getAssignedQuiz($quiz->id, auth()->user()->id);
                    if (!$isAlreadyAssigned && $quiz->status == 'published') {
                        $isAssigned = true;
                        $quizDetail = (new \Modules\Quiz\Services\QuizService())->assignQuiz($quiz->id, [auth()->user()->id]);
                        $quizData   = Quiz::with('questions', 'tutor.profile')->whereStatus(Quiz::PUBLISHED)->find($quizDetail->quiz_id);

                        $emailData = [
                            'quizTitle'       => $quiz->title,
                            'studentName'     => $student?->profile?->full_name,
                            'tutorName'       => $quizData?->tutor?->profile?->full_name,
                            'quizUrl'         => route('quiz.student.quiz-details', ['attemptId' => $quizDetail?->id])
                        ];

                        $notifyData = [
                            'quizTitle'         => $quiz->title,
                            'studentName'       => $student?->profile?->full_name,
                            'tutorName'         => $quizData?->tutor?->profile?->full_name,
                            'assignedQuizUrl'   => route('quiz.student.quizzes')
                        ];

                        dispatch(new SendNotificationJob('assignedQuiz', $student, $emailData));
                        dispatch(new SendDbNotificationJob('assignedquiz', $student, $notifyData));
                    }
                }
            }
        }
        return $isAssigned;
    }

    public function assignAssignment()
    {
        $studentId = auth()->user()->id;
        $student = User::with('profile')->find($studentId);
        $isAssigned = false;
        if (isActiveModule('assignments')) {
            $assignments = $this->course?->assignments;
            if (!empty($assignments)) {

                foreach ($assignments as $assignment) {
                    $isAlreadyAssigned = (new \Modules\Assignments\Services\AssignemntsService())->getAssignedAssignment($assignment->id, auth()->user()->id);
                   
                    if (!$isAlreadyAssigned && $assignment->status == 'published') {
                        $isAssigned = true;
                        $assignmentDetail = (new \Modules\Assignments\Services\AssignemntsService())->assignAssignment($assignment->id, [auth()->user()->id]);
                        $assignmentData   = Assignment::with('tutor.profile')->whereStatus(Assignment::STATUS_PUBLISHED)->find($assignmentDetail->assignment_id);
                       
                        $emailData = [
                            'assignmentTitle'       => $assignment->title,
                            'studentName'           => $student?->profile?->full_name,
                            'tutorName'             => $assignmentData?->instructor?->profile?->full_name,
                            'assignedAssignmentUrl' => route('assignments.student.attempt-assignment', ['id' => $assignmentDetail?->id])
                        ];
       
                        $notifyData = [
                            'assignmentTitle'       => $assignment->title,
                            'studentName'           => $student?->profile?->full_name,
                            'tutorName'             => $assignmentData?->instructor?->profile?->full_name,
                            'assignedAssignmentUrl' => route('assignments.student.attempt-assignment', ['id' => $assignmentDetail?->id])
                        ];
                    
                        dispatch(new SendNotificationJob('assignedAssignment', $student, $emailData));
                        dispatch(new SendDbNotificationJob('assignedassignment', $student, $notifyData));
                    }
                }
            }
        }
        return $isAssigned;
    }

    public function generateCertificate()
    {

        $wildcard_data = [
            'tutor_name'         => $this->course?->instructor?->profile?->full_name ?? '',
            'student_name'       => auth()->user()->profile?->full_name ?? '',
            'gender'             => !empty(auth()->user()->profile?->gender) ? ucfirst(auth()->user()->profile?->gender) : '',
            'tutor_tagline'      => $this->course?->instructor?->profile?->tagline ?? '',
            'issued_by'          => $this->course?->instructor?->profile?->full_name ?? '',
            'platform_name'      => setting('_general.site_name'),
            'platform_email'     => setting('_general.site_email'),
            'course_title'       => $this->course?->title ?? '',
            'course_subtitle'    => $this->course?->subtitle ?? '',
            'course_description' => $this->course?->description ?? '',
            'course_category'    => $this->course?->category?->name ?? '',
            'course_subcategory' => $this->course?->subCategory?->name ?? '',
            'course_type'        => $this->course?->type ?? '',
            'course_level'       => $this->course?->level ?? '',
            'course_language'    => $this->course?->language?->name ?? '',
            'free_course'        => $this->course?->is_free ? 'Yes' : 'No',
            'course_price'       => $this->course?->pricing?->price ? formatAmount($this->course?->pricing?->price) : '',
            'course_discount'    => $this->course?->pricing?->discount ? formatAmount($this->course?->pricing?->discount) : '',
            'issue_date'         => now()->format(setting('_general.date_format')),
            'student_email'      => auth()->user()->email ?? '',
            'tutor_email'        => $this->course?->instructor?->email ?? '',
        ];

        generate_certificate(template_id: $this->course?->certificate_id, generated_for_type: 'App\Models\User', generated_for_id: auth()->user()->id, wildcard_data: $wildcard_data);
    }

    public function submitRating()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $data = $this->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'description' => 'required|string|max:1000',
        ]);

        $isAdded = (new CourseService())->addCourseRating($this->course->id, $data);
        if ($isAdded) {
            $this->dispatch('showAlertMessage', type: 'success', title: __('courses::courses.rating_added'), message: __('courses::courses.rating_added_successfully'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('courses::courses.error_title'), message: __('courses::courses.rating_add_failed'));
        }

        $courseRatings = (new CourseService())->getCourse(
            courseId: $this->course->id,
            relations: ['ratings']
        );

        $this->studentRating = $courseRatings->ratings->where('student_id', auth()->id())->first();
    }

    private function getCourseSingedUrl($path) {
        $finalPath = Str::replace(['courses/', 'curriculum_videos/'], '', $path);
        return URL::signedRoute('courses.secure.video', [
            'path' => $finalPath, 
            'type' => base64_encode(Str::contains($path, 'curriculum_videos') ? 'curriculum_videos' : 'courses')
        ]);
    }

    private function setActiveCurriculmPath()
    {
        if(!empty($this->activeCurriculum['media_path'])) {
            if(getStorageDisk() !== 's3') {
                // $this->activeCurriculum['media_path'] = $this->getCourseSingedUrl($this->activeCurriculum['media_path'], $this->activeCurriculum['content_length']);
                $this->activeCurriculum['media_path'] = Storage::url($this->activeCurriculum['media_path']);
            }else {
                $this->activeCurriculum['media_path'] = Storage::url($this->activeCurriculum['media_path']);
            }
        } else{
            $this->activeCurriculum['media_path'] = null;
        }
    }
}
