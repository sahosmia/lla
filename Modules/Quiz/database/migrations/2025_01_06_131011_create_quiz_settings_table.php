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
        Schema::create(config('quiz.db_prefix') . 'quiz_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained(config('quiz.db_prefix') . 'quizzes')->onDelete('cascade');
            $table->string('meta_key', 255);
            $table->string('meta_value')->nullable();
            $table->timestamps();

            $table->unique(['quiz_id', 'meta_key']);
            $table->index(['quiz_id', 'meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'quiz_settings');
    }
};
