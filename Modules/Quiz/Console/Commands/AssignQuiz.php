<?php

namespace Modules\Quiz\Console\Commands;

use Illuminate\Console\Command;
use Modules\Quiz\Models\Quiz;
use Modules\Quiz\Services\QuizService;
use App\Models\User;
use Modules\Quiz\Models\QuizAttempt;

class AssignQuiz extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'quiz:assign 
                            {quiz_id : The ID of the quiz to assign} 
                            {student_id : The ID of the student to assign the quiz to}';

    /**
     * The console command description.
     */
    protected $description = 'Assign a quiz to a student (for development/testing purposes only)';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $quiz_id = (int) $this->argument('quiz_id');
        $student_id = (int) $this->argument('student_id');

        QuizAttempt::where('quiz_id', $quiz_id)->where('student_id', $student_id, $student_id)->delete();

        $quiz = Quiz::where('id', $quiz_id)
            ->where('status', Quiz::PUBLISHED)->first();

        if (!$quiz) {
            $this->error('Quiz not found or not published.');
            return;
        }

        $student = User::where('id', $student_id)
            ->where('status', '1')
            ->first();

        if (!$student) {
            $this->error('Student not found or not active.');
            return;
        }

        $quizService = new QuizService();
        $quizService->assignQuiz($quiz_id, [$student_id]);

        $this->info("✅ Quiz (ID: $quiz_id) successfully assigned to student (ID: $student_id).");
    }
}
