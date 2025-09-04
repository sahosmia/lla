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
        Schema::create(config('quiz.db_prefix') . 'attempted_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained(config('quiz.db_prefix') . 'quiz_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained(config('quiz.db_prefix') . 'questions')->onDelete('cascade');
            $table->text('answer')->nullable();
            $table->unsignedBigInteger('question_option_id')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->integer('marks_awarded')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['quiz_attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'attempted_questions');
    }
};
