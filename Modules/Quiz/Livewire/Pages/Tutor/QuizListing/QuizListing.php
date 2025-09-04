<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizListing;

use App\Models\UserSubjectGroupSubject;
use App\Services\BookingService;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Quiz\Livewire\Forms\CreateFormQuiz;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuizService;


class QuizListing extends Component
{
    use WithPagination;

    public CreateFormQuiz $form;

    public $isLoading = true;
    public $showClearFilters = false;
    public $categories;
    public $counts = [];

    public $statuses = [];
    public $quiz;
    public $quizId;
    public $quizzable_types;
    public $duplicateQuizId;
    public $quizzable_ids = [];
    public $activeRoute       = '';
    public $slots = [];
    public $parPageList = [8, 16, 24, 64];
    public $user;
    public $filters = [
        'keyword'  => null,
        'per_page' => 8,
        'status'   => '',
    ];
    public $category_id = null;

    public $dateFormat      = '';
    public $timeFormat      = '';


    protected QuizService $quizService;
    protected BookingService $bookingService;
    protected SubjectService $subjectService;

    public function boot(QuizService $quizService)
    {
        $this->user = Auth::user();
        $this->quizService = $quizService;
        $this->bookingService   = new BookingService($this->user);
        $this->subjectService   = new SubjectService($this->user);
    }

    public function mount()
    {
        $this->activeRoute = Route::currentRouteName();

        $this->showClearFilters = false;
        $this->dispatch('initSelect2', target: '.am-select2');
        $this->dateFormat       = setting('_general.date_format');
        $this->timeFormat       = setting('_lernen.time_format');

        $this->quizzable_types = [
            [
                'label' => 'Subject',
                'value' => UserSubjectGroupSubject::class,
            ],
        ];

        $this->statuses = [
            Quiz::STATUS_DRAFT              => Quiz::STATUS_DRAFT,
            Quiz::STATUS_PUBLISHED          => Quiz::STATUS_PUBLISHED,
            Quiz::STATUS_ARCHIVED           => Quiz::STATUS_ARCHIVED,
        ];

        $this->form->setQuestionTypes();

        if (isActiveModule('Courses')) {
            $this->quizzable_types[] = [
                'label' => 'Course',
                'value' => \Modules\Courses\Models\Course::class,
            ];
        } else {
            $this->form->quizzable_type = UserSubjectGroupSubject::class;
            $data = $this->initOptions($this->form->quizzable_type);
            $this->dispatch('quizValuesUpdated', options: $data, reset: false);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $quizzes = $this->quizService->getQuizzesList($this->filters);
        return view('quiz::livewire.tutor.quiz-listing.quiz-listing', compact('quizzes'));
    }

    public function filterStatus($status)
    {
        $this->filters['status'] = $status;
    }

    public function resetFilters()
    {
        $this->filters = [
            'keyword'   => null,
            'per_page'  => 8,
            'status'    => '',
        ];
        $this->showClearFilters = false;
        $this->resetPage();
        $this->dispatch('resetFilters');
    }

    public function loadData()
    {
        $this->isLoading = false;
    }

    public function archivedQuiz($quizId, $status)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $status = $status === 'archived' ? 'published' : 'archived';
        $result = $this->quizService->archivedQuiz($quizId, $status);
        if (!empty($result)) {
            if ($status == 'published') {
                $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.unarchived_success'), message: __('quiz::quiz.quiz_unarchived_successfully'));
            } else {
                $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.archived_success'), message: __('quiz::quiz.quiz_archived_successfully'));
            }
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.error'), message: __('quiz::quiz.quiz_archive_failed'));
        }
    }


    public function duplicateQuiz()
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        try {
            $quiz = $this->quizService->duplicateQuiz($this->duplicateQuizId);

            if ($quiz) {
                $this->dispatch(
                    'showAlertMessage',
                    type: 'success',
                    title: __('quiz::quiz.quiz_duplicated'),
                    message: __('quiz::quiz.quiz_duplicated_successfully')
                );
            } else {
                $this->dispatch(
                    'showAlertMessage',
                    type: 'error',
                    title: __('quiz::quiz.error_title'),
                    message: __('quiz::quiz.quiz_duplicated_failed')
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                title: __('general.error_title'),
                message: __('general.went_wrong')
            );
        }
        $this->dispatch('toggleModel', id: 'duplicate_popup', action: 'hide');
    }

    public function updatedForm($value, $key)
    {
        if ($key == 'quizzable_type' && (!empty($this->form->quizzable_type))) {
            $data = $this->initOptions($value);
            $this->dispatch('quizValuesUpdated', options: $data, reset: true);
            if ($value == 'App\Models\UserSubjectGroupSubject') {
                $this->dispatch('initSelect2', target: '.am-select2');
                $this->dispatch('slotsList');
            }
        } elseif ($key == 'quizzable_id') {

            $this->slots = $this->bookingService->getAvailableSubjectSlots($value, $this->dateFormat, $this->timeFormat);
            $this->dispatch('addSlotsOptions', options: $this->slots);
        }
    }

    public function initOptions($type)
    {
        if ($type == \Modules\Courses\Models\Course::class) {
            $courses = (new \Modules\Courses\Services\CourseService())->getInstructorCourses(Auth::id(), [], ['title', 'id']);
            return $courses->map(fn($course) => ['text' => $course->title, 'id' => $course->id, 'selected' => !empty($this->form->quizzable_id) ? $this->form->quizzable_id == $course->id : false]) ?? [];
        } else if ($type == UserSubjectGroupSubject::class) {
            $subjectGroups = $this->subjectService->getUserSubjectGroups(['subjects:id,name', 'group:id,name']);
            $formattedData = [];
            foreach ($subjectGroups as $sbjGroup) {
                if ($sbjGroup->subjects->isEmpty()) {
                    continue;
                }
                $groupData = [
                    'text' => $sbjGroup->group->name,
                    'children' => []
                ];

                if ($sbjGroup->subjects) {
                    foreach ($sbjGroup->subjects as $sbj) {
                        $groupData['children'][] = [
                            'id' => $sbj->pivot->id,
                            'text' => $sbj->name,
                            'selected' => !empty($this->form->quizzable_id) ? $this->form->quizzable_id == $sbj->pivot->id : false
                        ];
                    }
                }
                $formattedData[] = $groupData;
            }

            return $formattedData;
        }
    }

    public function saveQuiz()
    {
        $quiz = $this->form->validateQuizDetail();
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $quiz = $this->quizService->createQuiz($quiz);
        if (!empty($quiz)) {
            $this->quizId = $quiz->id;
            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_updated'), message: __('quiz::quiz.quiz_created_successfully'));
            return route('quiz.tutor.quiz-settings', ['quizId' => $quiz->id]);
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.qui_creation_error'), message: __('quiz::quiz.qui_creation_error_text'));
        }
    }


    /**
     * Prepare Quiz with AI
     */
    public function generateAiQuiz()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            $this->dispatch('toggleModel', id: 'create-quiz-model', action: 'hide');
            return;
        }
        if (empty(setting('_api.openai_api_key'))) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.openai_api_key_missing'));
            $this->dispatch('toggleModel', id: 'create-quiz-model', action: 'hide');
            return;
        }
        $this->form->validateAi();
        $hasAtLeastOneQuestion = false;
        foreach ($this->form->question_types as $key => $value) {
            if (!empty($value) && $value > 0) {
                $hasAtLeastOneQuestion = true;
            }
        }
        if (!$hasAtLeastOneQuestion) {
            $this->addError('question_types', __('quiz::quiz.question_types_required'));
            return;
        }
        $quizResp = $this->quizService->createAiQuiz(array_merge($this->form->all()));
        $this->dispatch('toggleModel', id: 'quizModal', action: 'hide');
        $this->dispatch('showAlertMessage', type: $quizResp['success'] ? 'success' : 'error', message: $quizResp['message']);
        if (!empty($quizResp['success']) && !empty($quizResp['quiz']->id)) {
            return redirect()->route('quiz.tutor.question-manager', ['quizId' => $quizResp['quiz']->id]);
        }
    }
}
