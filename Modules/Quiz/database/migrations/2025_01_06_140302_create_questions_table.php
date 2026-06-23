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
        Schema::create(config('quiz.db_prefix') . 'questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained(config('quiz.db_prefix') . 'quizzes')->onDelete('cascade');
            $table->string('title');
            $table->tinyInteger('type')->default(1)->comment('1: mcq, 2: true_false, 3: open_ended_essay, 4: fill_in_blanks, 5: short_answer');
            $table->text('description')->nullable();
            $table->integer('points')->default(1);
            $table->json('settings')->nullable();
            $table->integer('position');
            $table->timestamps();
            $table->index('quiz_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'questions');
    }
};
