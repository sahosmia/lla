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
        Schema::create(config('quiz.db_prefix') . 'quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->string('quizzable_type');
            $table->unsignedBigInteger('quizzable_id');
            $table->json('user_subject_slots')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 => draft, 1 => published, 2 => archived');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'quizzes');
    }
};
