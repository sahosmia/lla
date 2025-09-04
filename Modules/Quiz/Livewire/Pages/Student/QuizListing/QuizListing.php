<?php

namespace Modules\Quiz\Livewire\Pages\Student\QuizListing;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Quiz\Services\QuizService;


class QuizListing extends Component
{
    use WithPagination;

    public $isLoading   = true;
    public $parPageList = [8, 32, 64, 128];
    public $user;
    public $perPage;
    public $filters = [
        'status'           => 'upcoming',
        'keyword'          => null,
        'per_page'         => 10,
    ];

    protected QuizService $quizService;

    public function boot(QuizService $quizService)
    {
        $this->user = Auth::user();
        $this->quizService = $quizService;
    }

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $quizAttempts = $this->quizService->getAttemptedQuizzes(
            select: [
                'id',
                'quiz_id',
                'student_id',
                'started_at',
                'total_marks',
                'correct_answers',
                'incorrect_answers',
                'earned_marks',
                'total_questions',
                'result',
            ],
            relations: [
                'quiz' => function ($query) {
                    $query->select('id', 'title', 'quizzable_id', 'quizzable_type', 'created_at');
                    $query->withCount('questions');
                    $query->with([
                        'settings',
                        'quizzable',
                        'thumbnail:mediable_id,mediable_type,type,path',
                    ]);
                }
            ],
            studentId: $this->user->id,
            filters: $this->filters
        );

        return view('quiz::livewire.student.quiz-listing.quiz-listing', compact('quizAttempts'));
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }


    public function loadData()
    {
        $this->isLoading = false;
    }

    public function filterStatus($status)
    {
        $this->filters['status'] = $status;
        $this->resetPage();
    }
}
