<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;

use App\Models\UserSubjectGroupSubject;
use App\Services\BookingService;
use App\Services\SubjectService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Quiz\Livewire\Forms\CreateFormQuiz;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuizService;

class EditQuiz extends Component
{
    public CreateFormQuiz $form;

    public $quizId;
    public $quiz;
    public $user;
    public $isUpdate = false;
    public $quizzable_ids = [];
    public $slots = [];
    protected $quizService, $subjectService, $bookingService;
    public $sessions = [];
    public $selectedSubjectSlots = [];
    public $allowVideoSize  = '';
    public $allowVideoExt   = [];
    public $mediaType       = '';
    public $loadingQuestion = false;
    public $qType = '';
    public $dateFormat      = '';
    public $timeFormat      = '';
    public $routeName       = '';
    public $quizStatus       = '';

    public function boot()
    {
        $this->user = Auth::user();
        $this->subjectService   = new SubjectService($this->user);
        $this->bookingService   = new BookingService($this->user);
        $this->quizService      = new QuizService();
        
    }

    public function mount($quizId = null)
    {
        $this->routeName = Route::currentRouteName();
        $quiz = $this->quizService->getQuiz(
            select: ['id', 'title', 'quizzable_type', 'quizzable_id', 'user_subject_slots', 'description', 'status'],
            quizId: $this->quizId,
            tutorId: $this->user->id,
            relations: ['settings:meta_key,meta_value']
        );

        
        if (empty($quiz) || $quiz?->status == Quiz::STATUS_ARCHIVED ) {
            abort(404);
        }

        $this->quizStatus       = $quiz?->status;
        $this->dateFormat       = setting('_general.date_format');
        $this->timeFormat       = setting('_lernen.time_format');

        $this->quiz = $quiz;
        $this->quizId = (int)$quizId;
        $this->form->setQuizDetail($this->quiz);

        $this->quizzable_ids = $this->initOptions($this->form->quizzable_type);
        if($this->form->quizzable_type == UserSubjectGroupSubject::class){
            $slotData = $this->bookingService->getAvailableSubjectSlots($this->form->quizzable_id, $this->dateFormat, $this->timeFormat);
            
            if(!empty($slotData)){
                $this->selectedSubjectSlots = array_filter($slotData, function ($slot) {
                    return !empty($this->quiz->user_subject_slots) ? in_array($slot['id'], $this->quiz->user_subject_slots) : false;
                });
                if(empty($this->selectedSubjectSlots)){
                    $this->form->user_subject_slots = [];
                }

                $this->slots =  array_map(function ($slot) {
                    $slot['selected'] = $this->quiz->user_subject_slots ? in_array($slot['id'], $this->quiz->user_subject_slots) : false;
                    return $slot;
                }, $slotData);

            } else {
                $this->form->user_subject_slots = [];
                $this->slots = [];
                $this->selectedSubjectSlots = [];
            }
        }        
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('quiz::livewire.tutor.quiz-creation.edit-quiz-detail');
    }


    public function updatedForm($value, $key)
    {
        if (str_contains($key, 'quizzable_type')) {
            $data = $this->initOptions($this->form->quizzable_type);
            $this->dispatch('quizValuesUpdated', options: $data, reset: true, target: '#quizzable_id');
            if($value == UserSubjectGroupSubject::class){
                $this->dispatch('initSelect2', target: '.am-select2' );
                $this->dispatch('slotsList');
            }
        } elseif (str_contains($key, 'quizzable_id')) {
            if ($this->form->quizzable_type == UserSubjectGroupSubject::class) {
                $this->slots = $this->bookingService->getAvailableSubjectSlots($this->form->quizzable_id, $this->dateFormat, $this->timeFormat);
                $this->dispatch('addSlotsOptions', options:  $this->slots, reset: true);
                $this->dispatch('slotsList');
            } else {
                $this->form->user_subject_slots = [];
            }
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

    public function updateQuiz()
    {
        // dd($this->quizzable_ids);
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if($this->quizStatus == Quiz::STATUS_PUBLISHED){
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.not_allowd'), message: __('quiz::quiz.not_perform_action'));
            return;
        }
        
        $quiz = $this->form->validateQuizDetail();
        $response = isDemoSite();

        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $quiz = $this->quizService->updateQuiz($this->quizId, $quiz);
        if (empty($quiz)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.qui_creation_error'), message: __('quiz::quiz.qui_creation_error_text'));
        }
        $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_updated'), message: __('quiz::quiz.quiz_updated_successfully'));
    }

}
