<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('quiz.db_prefix') . 'quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained(config('quiz.db_prefix') . 'quizzes')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('active_question_id')->nullable()->constrained(config('quiz.db_prefix') . 'questions')->onDelete('set null');
            $table->unsignedInteger('total_questions')->default(0);
            $table->unsignedInteger('total_marks')->default(0);
            $table->unsignedInteger('correct_answers')->default(0);
            $table->unsignedInteger('incorrect_answers')->default(0);
            $table->unsignedInteger('earned_marks')->default(0);
            $table->tinyInteger('result')->default(0)->comment('0 => assigned, 1 => in_review, 2 => pass, 3 => fail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'quiz_attempts');
    }
};
