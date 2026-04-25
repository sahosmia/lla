<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;

use Modules\Quiz\Livewire\Forms\CreateFormQuiz;
use App\Models\UserSubjectGroupSubject;
use Illuminate\Support\Facades\Auth;
use App\Services\SubjectService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;
use Modules\Quiz\Models\Question;
use Livewire\Attributes\On;
use App\Services\BookingService;
use Illuminate\Support\Facades\Route;
use Modules\Quiz\Livewire\Forms\FillInBlanksForm;
use Modules\Quiz\Livewire\Forms\ShortAnswerForm;
use Modules\Quiz\Livewire\Forms\McqForm;
use Modules\Quiz\Livewire\Forms\OpenEndedEssayForm;
use Modules\Quiz\Livewire\Forms\TrueFalseForm;
use Livewire\WithFileUploads;

class CreateQuiz extends Component
{
    use WithFileUploads;
    public CreateFormQuiz $form;
    public TrueFalseForm $trueFalseForm;
    public McqForm $mcqForm;
    public OpenEndedEssayForm $openEndedEssayForm;
    public FillInBlanksForm $fillInBlanksForm;
    public ShortAnswerForm $shortAnswerForm;

    public $quizId;
    public $questionId;
    public $quiz;
    public $autoResultGenerte = false;
    public $user;
    public $tabs;
    public $tab = 'details';
    public $questions;
    public $questionType;
    public $questionTypes = [];
    public $quizzable_types;
    public $isEdit = false;
    public $isUpdate = false;
    public $quizzable_ids = [];
    public $slots = [];
    protected $quizService, $subjectService, $questionService, $bookingService;
    public $sessions = [];
    public $selectedSubjectSlots = [];
    public $activeForm = null;

    public $question_title;
    public $question_text;
    public $answer_explanation;
    public $correct_answer;

    public $mcq             = null;
    public $mcqCorrect      = false;

    public $answerRequired  = false;
    public $displayPoints   = false;
    public  $randomChoice   = false;
    public $points          = 1;

    public $allowImageSize  = '';
    public $allowImgFileExt = [];
    public $fileExt         = [];
    public $questionMedia   = '';


    public $dateFormat      = '';
    public $timeFormat      = '';

    public $allowVideoSize  = '';
    public $allowVideoExt   = [];
    public $mediaType       = '';
    public $activeRoute       = '';

    public $loadingQuestion = false;
    public $qType = '';
    public $quizStatus = '';



    public function boot()
    {
        $this->user = auth()->user();
        $this->subjectService   = new SubjectService($this->user);
        $this->bookingService   = new BookingService($this->user);
        $this->quizService      = new QuizService();
        $this->questionService  = new QuestionService();
    }

    public function mount($quizId = null)
    {
        $this->isEdit = Route::is('quiz.tutor.quiz-question-bank');
        $this->activeRoute = Route::currentRouteName();

        if ($this->activeRoute == 'quiz.tutor.quiz-question-bank' && !empty($quizId)) {
            $quiz = $this->quizService->getQuiz(
                select: ['id', 'title', 'quizzable_type', 'quizzable_id', 'user_subject_slots', 'description', 'status'],
                quizId: $this->quizId,
                tutorId: $this->user->id,
                relations: ['settings:meta_key,meta_value']
            );

            if (empty($quiz) || $quiz?->status == 'archived') {
                abort(404);
            }
            $this->quiz = $quiz;
            $this->quizStatus = $quiz?->status;
            $this->quizId = (int)$quizId;
            $this->form->setQuizDetail($this->quiz);
            $this->updatedForm($this->quiz?->quizzable_type, 'quizzable_type');
            $this->updatedForm($this->quiz?->quizzable_id, 'quizzable_id');
            $this->questions = $this->questionService->getQuestions($this->quizId);
            if ($this->questions->isNotEmpty()) {
                $this->editQuestion($this->questions->first()->id);
            }
        }

        $image_file_ext          = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $image_file_size         = (int) (setting('_general.max_image_size') ?? '5');
        $this->allowImageSize    = !empty($image_file_size) ? $image_file_size : '5';
        $this->allowImgFileExt   = !empty($image_file_ext) ?  explode(',', $image_file_ext) : [];
        $video_file_size         = setting('_general.max_video_size');
        $video_file_ext          = setting('_general.allowed_video_extensions');
        $this->allowVideoSize    = (int) (!empty($video_file_size) ? $video_file_size : '20');
        $this->allowVideoExt = !empty($video_file_ext) ?  explode(',', $video_file_ext) : [];

        $this->dateFormat       = setting('_general.date_format');
        $this->timeFormat       = setting('_lernen.time_format');

        $this->fileExt           = fileValidationText($this->allowImgFileExt);

        $this->dispatch('initSelect2', target: '.am-select2');
        $this->quizzable_types = [
            [
                'label' => 'Subject',
                'value' => UserSubjectGroupSubject::class,
            ],
        ];

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

        if (!empty($this->quiz->settings)) {
            $this->autoResultGenerte = $this->quiz->settings->where('meta_key', 'auto_result_generate')?->first()?->meta_value[0] ?? false;
        }

        $this->questionTypes = [
            ['type' => Question::TYPE_TRUE_FALSE, 'is_disabled' => false],
            ['type' => Question::TYPE_MCQ, 'is_disabled' => false],
            ['type' => Question::TYPE_OPEN_ENDED_ESSAY, 'is_disabled' => $this->autoResultGenerte],
            ['type' => Question::TYPE_FILL_IN_BLANKS, 'is_disabled' => false],
            ['type' => Question::TYPE_SHORT_ANSWER, 'is_disabled' => $this->autoResultGenerte],
        ];
        if (!empty($this->quizId)) {
            $this->questions = $this->questionService->getQuestions($this->quizId);
        }
        return view('quiz::livewire.tutor.quiz-creation.create-quiz', [
            'id'            => $this->quizId,
        ]);
    }

    public function changeTab($tab)
    {
        if ($tab == 'settings' && empty($this->quizId)) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.fiil_detail'), message: __('quiz::quiz.please_add_quiz_detail_first'));
            return;
        }
        $this->tab = $tab;
        return redirect()->route('quiz.tutor.create-quiz-settings', ['id' => $this->quizId]);
    }

    public function editQuiz()
    {

        $this->isUpdate = true;
        $this->quiz = $this->quizService->getQuiz(
            select: ['id', 'title', 'quizzable_type', 'quizzable_id', 'user_subject_slots', 'description'],
            quizId: $this->quizId,
            tutorId: $this->user->id,
            relations: ['settings:meta_key,meta_value']
        );

        $quizzable_type = $this->quiz->quizzable_type;
        $quizzable_id = $this->quiz->quizzable_id;
        $this->form->setQuizDetail($this->quiz);
        $data = $this->initOptions($quizzable_type);
        $this->slots = [];

        if ($quizzable_type == UserSubjectGroupSubject::class) {
            $slotData = $this->bookingService->getAvailableSubjectSlots($quizzable_id, $this->dateFormat, $this->timeFormat);
            $this->selectedSubjectSlots = array_filter($slotData, function ($slot) {
                return $this->quiz->user_subject_slots ? in_array($slot['id'], $this->quiz->user_subject_slots) : false;
            });

            $this->slots =  array_map(function ($slot) {
                $slot['selected'] = $this->quiz->user_subject_slots ? in_array($slot['id'], $this->quiz->user_subject_slots) : false;
                return $slot;
            }, $slotData);
        }

        $eventData = [
            'quizzable_type' => $quizzable_type,
            'option_list' => $data,
            'session_slots' => $session_slots ?? []
        ];
        $this->isEdit = false;
        $this->dispatch('editQuiz', eventData: $eventData);
    }

    public function updatedActiveForm($value, $key)
    {

        list($variable_name, $index, $keyname) = array_pad(explode(".", $key), 3, null);
        if ($variable_name == 'images') {
            $mimeType = $value->getMimeType();
            $type = explode('/', $mimeType);
            $allowedImageExtensions = $this->allowImgFileExt;
            $allowedVideoExtensions = $this->allowVideoExt;
            $allowedImageSize = $this->allowImageSize * 1024;
            $allowedVideoSize = $this->allowVideoSize * 1024;

            if (!in_array($value->getClientOriginalExtension(), $allowedImageExtensions)) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.invalid_file_type', ['file_types' => fileValidationText($allowedImageExtensions)]));
                $this->activeForm->{$variable_name}[$index][$keyname] = '';
                return;
            }

            if ($value->getSize() / 1024 > $allowedImageSize) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.file_size_exceeded', ['max_size' => $this->allowImageSize]));
                $this->activeForm->{$variable_name}[$index][$keyname] = '';
                return;
            }
        }
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

    public function updatedQuestionMedia($value)
    {

        $mimeType = $value->getMimeType();
        $type = explode('/', $mimeType);

        $allowedImageExtensions = $this->allowImgFileExt;
        $allowedVideoExtensions = $this->allowVideoExt;
        $allowedImageSize = $this->allowImageSize * 1024;
        $allowedVideoSize = $this->allowVideoSize * 1024;



        if ($type[0] === 'image') {

            if (!in_array($value->getClientOriginalExtension(), $allowedImageExtensions)) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.invalid_file_type', ['file_types' => fileValidationText($allowedImageExtensions)]));
                $this->questionMedia = null;
                return;
            }

            if ($value->getSize() / 1024 > $allowedImageSize) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.file_size_exceeded', ['max_size' => $this->allowImageSize]));
                $this->questionMedia = null;
                return;
            }
            $this->mediaType = 'image';
        } elseif ($type[0] === 'video') {

            if (!in_array($value->getClientOriginalExtension(), $allowedVideoExtensions)) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.invalid_file_type', ['file_types' => fileValidationText($allowedVideoExtensions)]));
                $this->questionMedia = null;
                return;
            }

            if ($value->getSize() / 1024 > $allowedVideoSize) {
                $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.file_size_exceeded', ['max_size' => $this->allowVideoSize]));
                $this->questionMedia = null;
                return;
            }
            $this->mediaType = 'video';
        } else {

            $this->dispatch('showAlertMessage', type: 'error', message: __('validation.invalid_file_type', ['file_types' => fileValidationText(array_merge($allowedImageExtensions, $allowedVideoExtensions))]));
            $this->questionMedia = null;
            return;
        }
    }

    public function removeMedia()
    {
        $this->questionMedia = null;
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

        $quiz    = $this->quizService->createQuiz($quiz);
        if (!empty($quiz)) {
            $this->quiz = $quiz;
            $this->quizId = $quiz->id;
            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_updated'), message: $this->isEdit ? __('quiz::quiz.quiz_updated_successfully') : __('quiz::quiz.quiz_created_successfully'));
            $this->isEdit = true;
            return route('quiz.tutor.quiz-question-bank', ['quizId' => $quiz->id]);
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.qui_creation_error'), message: __('quiz::quiz.qui_creation_error_text'));
        }
    }

    public function updateQuiz()
    {
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
        $this->isEdit = true;
    }

    public function getForm($type)
    {
        switch ($type) {
            case Question::TYPE_TRUE_FALSE:
                $this->activeForm = $this->trueFalseForm;
                break;
            case Question::TYPE_MCQ:
                $this->activeForm = $this->mcqForm;
                break;
            case Question::TYPE_OPEN_ENDED_ESSAY:
                $this->activeForm = $this->openEndedEssayForm;
                break;
            case Question::TYPE_FILL_IN_BLANKS:
                $this->activeForm = $this->fillInBlanksForm;
                break;
            case Question::TYPE_SHORT_ANSWER:
                $this->activeForm = $this->shortAnswerForm;
                break;
            default:
                $this->activeForm = null;
                break;
        }
    }

    public function selectQuestionType($questionType)
    {
        if (in_array($questionType, [Question::TYPE_SHORT_ANSWER, Question::TYPE_OPEN_ENDED_ESSAY]) && $this->autoResultGenerte) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('This question type is diesabled'), message: __('This question type is diesabled'));
            return;
        }
        $this->getForm($questionType);
        $this->activeForm->reset();
        $this->resetQuestionSettings();
        $this->questionType = $questionType;
        $this->questionId = null;
        $this->questionMedia = null;
    }

    /**
     * Save a question based on its type.
     */
    public function saveQuestion()
    {

        $formData = $this->activeForm->saveQuestion();

        if (empty($formData)) {
            return;
        }

        if (empty($this->points) || (int)$this->points <= 0) {
            $this->addError('points', 'Please enter a valid points');
            return;
        }

        $settings = [
            'quiz_id'         => (int) $this->quizId,
            'answer_required' => $this->answerRequired ?? false,
            'display_points'  => $this->displayPoints ?? false,
            'random_choice'   => $this->randomChoice ?? false,
            'points'          => $this->points ?? 1,
            'type'            => $this->questionType
        ];

        $formData = array_merge($formData, $settings);
        $question = (new QuestionService)->createQuestion($this->quizId, $formData, $this->questionId);
        $this->questionId = $question?->id ?? null;
        $questionMedia = setQuizMedia($this->questionMedia, $this->mediaType, $this->allowImgFileExt, $this->allowVideoExt);

        if ($question && $questionMedia['path']) {
            (new QuestionService)->createQuestionMedia([
                'mediable_id' => $question->id,
                'mediable_type' => Question::class,
                'type' => $questionMedia['type'],
                'path' => $questionMedia['path']
            ]);
        }

        $this->dispatch(
            'showAlertMessage',
            type: 'success',
            title: $this->questionId ? __('quiz::quiz.question_updated_successfully') : __('quiz::quiz.question_added_successfully'),
            message: $this->questionId ? __('quiz::quiz.question_updated_successfully') : __('quiz::quiz.question_added_successfully')
        );
    }

    public function resetQuestionSettings()
    {
        $this->answerRequired = false;
        $this->displayPoints = false;
        $this->randomChoice = false;
        $this->points = 1;
    }

    public function addMcqOption()
    {

        if (count($this->activeForm->mcqs) >= 5) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.mcq_limit_exceed'), message: __('quiz::quiz.mcq_limit_exceed_text'));
            return;
        }
        $this->activeForm->addMcqOption();
    }

    public function addImageOption()
    {
        if (count($this->activeForm->images) >= 5) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.image_limit_exceed'), message: __('quiz::quiz.image_limit_exceed_text'));
            return;
        }
        $this->activeForm->images[] = [
            'option_image' => '',
        ];

        $this->activeForm->correct_answer = null;
    }

    /**
     * Prepare Quiz with AI
     */
    public function prepareAiQuiz()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        if (empty(setting('_api.openai_api_key'))) {
            $this->dispatch('showAlertMessage', type: 'error', message: __('general.openai_api_key_missing'));
            return;
        }
        $this->form->validateAi();
        $this->dispatch('toggleModel', id: 'ai-quiz-modal', action: 'show');
    }

    /**
     * Generate Quiz with AI
     */
    public function generateQuiz($answers)
    {
        $quizResp = $this->quizService->createAiQuiz(array_merge($this->form->all(), $answers));

        $this->dispatch('toggleModel', id: 'ai-quiz-modal', action: 'hide');
        $this->dispatch('showAlertMessage', type: $quizResp['success'] ? 'success' : 'error', message: $quizResp['message']);

        if (!empty($quizResp['success']) && !empty($quizResp['quiz']->id)) {
            return redirect()->route('quiz.tutor.quiz-question-bank', ['quizId' => $quizResp['quiz']->id]);
        }
    }

    #[On('delete-question')]
    public function deleteQuestion($params)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $this->questionService->deleteQuestion($params['questionId']);
        $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.delete_question'), message: __('quiz::quiz.question_delete_successfully'));
    }

    /**
     * Edit a question
     *
     * @param int $id The id of the question
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function editQuestion($id)
    {
        $question =  $this->questionService->getQuestion($id);

        if (empty($question)) {
            abort(404);
        }

        $this->activeForm?->reset();
        $this->questionMedia    =  $question->media[0]->path ?? null;
        $this->mediaType        =  $question?->media[0]->type ?? null;
        $this->questionType     = $question?->type;
        $this->questionId       = $question?->id;
        $this->getForm($question?->type);
        $this->answerRequired   = $question->answer_required;
        $this->displayPoints    = $question->display_points;
        $this->randomChoice     = $question->random_choice;
        $this->points           = $question->points;

        $this->activeForm->setQuestion($question);
    }

    public function removeMcq($index)
    {
        $this->activeForm->removeMcq($index);
    }

    public function removeImage($index)
    {
        unset($this->activeForm->images[$index]);
        $this->activeForm->images = array_values($this->activeForm->images);
        $this->activeForm->correct_answer = null;
    }
    public function removeQustionMedia($index)
    {
        $this->activeForm->images[$index] = null;
        $this->activeForm->correct_answer = null;
    }

    public function onCancel()
    {
        $this->isEdit = true;
    }

    public function updateQuistionPosition($list)
    {
        $response = isDemoSite();

        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!empty($list)) {
            $response = $this->questionService->udpateQuestionPosition($this->quizId, $list);
        }
    }

    public function publishQuiz()
    {
        $publish = $this->quizService->publishQuiz($this->quizId);
        if (!empty($publish)) {
            $this->quizStatus = 'published';
            $this->dispatch('showAlertMessage', type: 'success', title: __('quiz::quiz.quiz_publish'), message: __('quiz::quiz.quiz_publish_successfully'));
            return redirect()->route('quiz.tutor.quizzes');
        } else {
            $this->dispatch('showAlertMessage', type: 'error', title: __('quiz::quiz.quiz_publish'), message: __('quiz::quiz.quiz_publish_failed'));
        }
    }
}
