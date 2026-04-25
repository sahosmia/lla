<?php

namespace Modules\Quiz\Livewire\Pages\Tutor\QuizCreation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Quiz\Models\QuizAttempt;
use Modules\Quiz\Services\QuizService;


class QuizAttempts extends Component
{
    use WithPagination;

    public $quizStatus;
    public $isLoading = true;
    public $showClearFilters        = false;
    public $categories;
    public $counts                  = [];
    public $parPageList             = [10, 20, 30, 50, 100, 200];
    public $user;
    public $perPage;
    public $quizId;
    public $routeName;
    public $statuses  =  [
        QuizAttempt::ASSIGNED   => QuizAttempt::RESULT_ASSIGNED,
        QuizAttempt::IN_REVIEW  => QuizAttempt::RESULT_IN_REVIEW,
        QuizAttempt::PASS       => QuizAttempt::RESULT_PASSED,
        QuizAttempt::FAIL       => QuizAttempt::RESULT_FAILED
    ];

    public $filters   = [
        'keyword'    => null,
        'category_id' => null,
        'per_page'   => 10,
        'sort_by'    => 'desc',
        'status'     => null,
    ];



    public $category_id = null;

    protected QuizService $quizService;

    public function boot(QuizService $quizService)
    {
        $this->user = Auth::user();
        $this->quizService = $quizService;
    }

    public function mount($quizId = null)
    {
        $this->quizStatus = $this->quizService->getQuizStatus($this->quizId);

        $this->routeName = Route::currentRouteName();
        $this->quizId = $quizId;
        $this->showClearFilters = false;
        $this->perPage = !empty(setting('_general.per_page_record')) ? setting('_general.per_page_record') : 10;
        $this->dispatch('initSelect2', target: '.am-select2');
    }

    #[Layout('layouts.app')]
    public function render()
    {

        $quizzes = $this->quizService->getAttemptedQuizzes(
            select: [
                'id',
                'quiz_id',
                'student_id',
                'started_at',
                'total_marks',
                'total_questions',
                'correct_answers',
                'incorrect_answers',
                'earned_marks',
                'result',
                'created_at'
            ],
            relations: [
                'quiz.quizzable',
                'quiz.thumbnail:mediable_id,mediable_type,type,path',
                'student.profile:id,user_id,first_name,last_name,image',
            ],
            tutorId: $this->user->id,
            quizId: $this->quizId,
            filters: $this->filters
        );

        $quizTile = $this->quizService->getQuizTile($this->quizId);

        return view('quiz::livewire.tutor.quiz-creation.quiz-attempts', compact('quizzes', 'quizTile'));
    }

    public function updatedFilters()
    {
        if ($this->filters['status'] == '') {
            $this->filters['status'] = null;
        }
        $this->showClearFilters = true;
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filters = [
            'keyword'          => null,
            'category_id'      => null,
            'min_price'        => null,
            'max_price'        => null,
            'per_page'         => 10,
            'status'           => null,
        ];
        $this->showClearFilters = false;
        $this->resetPage();
        $this->dispatch('resetFilters');
    }

    public function loadData()
    {
        $this->isLoading = false;
    }
}
