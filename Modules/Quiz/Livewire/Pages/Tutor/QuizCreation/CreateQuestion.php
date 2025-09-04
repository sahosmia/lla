<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;


use Illuminate\Support\Facades\Auth;
use App\Services\SubjectService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Quiz\Livewire\Forms\CreateFormQuiz;
use App\Services\BookingService;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Renderless;
use Modules\Quiz\Livewire\Forms\FillInBlanksForm;
use Modules\Quiz\Livewire\Forms\McqForm;
use Modules\Quiz\Livewire\Forms\OpenEndedEssayForm;
use Modules\Quiz\Livewire\Forms\ShortAnswerForm;
use Modules\Quiz\Livewire\Forms\TrueFalseForm;
use Modules\Quiz\Models\Question;
use Modules\Quiz\Services\QuestionService;
use Modules\Quiz\Services\QuizService;

class CreateQuestion extends Component
{
    use WithFileUploads;
    public CreateFormQuiz $form;
    public TrueFalseForm $trueFalseForm;
    public McqForm $mcqForm;
    public OpenEndedEssayForm $openEndedEssayForm;
    public FillInBlanksForm $fillInBlanksForm;
    public ShortAnswerForm $shortAnswerForm;

    public $quizId;
    public $questionType;
    public $questionTypes = [];

    public $questionId;
    public $quiz;
    public $autoResultGenerte = false;
    public $user;
    public $questions;
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

    public $question_count = 1;

    public $qType = '';
    public $quizStatus = '';
    public $routeName = '';


    public function boot()
    {
        $this->user = Auth::user();
        $this->subjectService   = new SubjectService($this->user);
        $this->bookingService   = new BookingService($this->user);
        $this->quizService      = new QuizService();
        $this->questionService  = new QuestionService();
    }

    public function mount($quizId = null, $questionType = null, $questionId = null)
    {

        $this->routeName        = Route::currentRouteName();
        $this->questionType     = $questionType;
        $this->quizId           = $quizId;
        $this->questionId       = $questionId;

        $this->getForm($questionType);
        $this->dispatch('initSelect2', target: '.am-select2');

        $this->quiz = $this->quizService->getQuiz(
            select: ['id', 'title', 'quizzable_type', 'quizzable_id', 'user_subject_slots', 'description', 'status'],
            quizId: $this->quizId,
            tutorId: $this->user->id,
            relations: ['settings:meta_key,meta_value']
        );

        if (empty($this->quiz) || $this->quiz?->status == 'archived' || $this->quiz?->status == 'published') {
            abort(404);
        }

        if (!empty($this->quiz->settings)) {
            $this->autoResultGenerte = $this->quiz->settings->where('meta_key', 'auto_result_generate')?->first()?->meta_value[0] ?? false;
        }

        $questionTypes = [Question::TYPE_TRUE_FALSE, Question::TYPE_MCQ, Question::TYPE_OPEN_ENDED_ESSAY];

        if (empty($this->autoResultGenerte)) {
            $questionTypes[] = Question::TYPE_FILL_IN_BLANKS;
            $questionTypes[] = Question::TYPE_SHORT_ANSWER;
        }

        if (!in_array($questionType, $questionTypes)) {
            abort(404);
        }

        $this->question_count = $this->quiz?->questions_count + 1;

        if (!empty($this->questionId)) {
            $question =  $this->questionService->getQuestion($questionId);

            if (empty($question) || $question?->type != $questionType) {
                abort(404);
            }
            $this->activeForm?->reset();
            $this->questionMedia    =  $question?->media[0]->path ?? null;
            $this->mediaType        =  $question?->media[0]->type ?? null;
            $this->questionType     = $question?->type;
            $this->questionId       = $question?->id;
            $this->getForm($question?->type);
            $this->answerRequired   = $question?->settings['answer_required'] ?? false;
            $this->displayPoints    = $question?->settings['display_points'] ?? false;
            $this->randomChoice     = $question?->settings['random_choice'] ?? false;
            $this->points           = $question?->points ?? 1;
            $this->activeForm->setQuestion($question);
        }


        $image_file_ext          = setting('_general.allowed_image_extensions') ?? 'jpg,png';
        $image_file_size         = (int) (setting('_general.max_image_size') ?? '5');
        $this->allowImageSize    = !empty($image_file_size) ? $image_file_size : '5';
        $this->allowImgFileExt   = !empty($image_file_ext) ?  explode(',', $image_file_ext) : [];
        $video_file_size         = setting('_general.max_video_size');
        $video_file_ext          = setting('_general.allowed_video_extensions');
        $this->allowVideoSize    = (int) (!empty($video_file_size) ? $video_file_size : '20');
        $this->allowVideoExt = !empty($video_file_ext) ?  explode(',', $video_file_ext) : [];
        $this->fileExt           = fileValidationText($this->allowImgFileExt);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $this->questionTypes = [
            ['type' => Question::TYPE_TRUE_FALSE, 'is_disabled' => false],
            ['type' => Question::TYPE_MCQ, 'is_disabled' => false],
            ['type' => Question::TYPE_FILL_IN_BLANKS, 'is_disabled' => false],
            ['type' => Question::TYPE_OPEN_ENDED_ESSAY, 'is_disabled' => $this->autoResultGenerte],
            ['type' => Question::TYPE_SHORT_ANSWER, 'is_disabled' => $this->autoResultGenerte],
        ];

        return view('quiz::livewire.tutor.quiz-creation.create-question', [
            'id'            => $this->quizId,
            'questionType' => $this->questionType
        ]);
    }

    public function updatedQuestionType()
    {
        return redirect()->route('quiz.tutor.create-question', ['quizId' => $this->quizId, 'questionType' => $this->questionType]);
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
        }
        // elseif ($type[0] === 'video') {

        //     if (!in_array($value->getClientOriginalExtension(), $allowedVideoExtensions)) {
        //         $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.invalid_file_type', ['file_types' => fileValidationText($allowedVideoExtensions)]));
        //         $this->questionMedia = null;
        //         return;
        //     }

        //     if ($value->getSize() / 1024 > $allowedVideoSize) {
        //         $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.file_size_exceeded', ['max_size' => $this->allowVideoSize]));
        //         $this->questionMedia = null;
        //         return;
        //     }
        //     $this->mediaType = 'video';
        // } 
        else {
            // $allowedVideoExtensions
            $this->dispatch('showAlertMessage', type: 'error', message: __('validation.invalid_file_type', ['file_types' => fileValidationText(array_merge($allowedImageExtensions))]));
            $this->questionMedia = null;
            return;
        }
    }

    public function removeMedia()
    {
        $this->questionMedia = null;
    }

    /**
     * Save a question based on its type.
     */
    public function saveQuestion()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $formData = $this->activeForm->saveQuestion();

        if (empty($formData)) {
            return;
        }


        if (empty($this->points) || (int)$this->points <= 0) {
            $this->addError('points', 'Please enter a valid points');
            return;
        }

        if (!ctype_digit((string)$this->points)) {
            $this->addError('points', 'Points must be a whole number');
            return;
        }

        if ($this->points > 100) {
            $this->addError('points', 'You can enter a maximum of 100 points');
            return;
        }


        $settings = [
            'quiz_id'         => (int) $this->quizId,
            'points'          => $this->points ?? 1,
            'type'            => $this->questionType,
            'settings'        => [
                'answer_required' => $this->answerRequired,
                'random_choice'   => $this->randomChoice,
            ],
        ];

        if ($this->questionType == Question::TYPE_MCQ) {
            $settings['settings']['display_points'] = $this->displayPoints;
        }

        $formData = array_merge($formData, $settings);
        $question = (new QuestionService)->createQuestion($this->quizId, $formData, $this->questionId);
        $questionMedia = setQuizMedia($this->questionMedia, $this->mediaType, $this->allowImgFileExt, $this->allowVideoExt);

        (new QuestionService())->deleteQuestionMedia($question);

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

        return redirect()->route('quiz.tutor.question-manager', ['quizId' => $this->quizId]);
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

    public function addFillInBlanksOption()
    {
        $this->activeForm->addFillInBlanksOption();
    }

    public function removeFillInBlanksOption($index)
    {
        $this->activeForm->removeFillInBlanksOption($index);
    }

    public function removeMcq($index)
    {
        $this->activeForm->removeMcq($index);
        // return;

        // if (count($this->activeForm->mcqs) > 1) {
        // }

        // $this->dispatch('showAlertMessage', type: 'error', message: __('quiz::quiz.cannot_remove_option'));
        // return;

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

    #[Renderless]
    public function updateOptionPosition($list)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }
        $sortedOptions = [];
        if (!empty($list)) {

            foreach ($list as $item) {

                $sortedOptions[] = $this->activeForm->blanks[$item['value']];
            }

            $this->activeForm->blanks = $sortedOptions;
        }
    }

    #[Renderless]
    public function updateMcqPosition($list)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $sortedOptions = [];
        if (!empty($list)) {

            foreach ($list as $item) {
                $option = $this->activeForm->mcqs[$item['value']];
                $option['position'] = $item['order'];
                $sortedOptions[$item['value']] = $option;
            }

            $this->activeForm->mcqs = $sortedOptions;
        }
    }
}
