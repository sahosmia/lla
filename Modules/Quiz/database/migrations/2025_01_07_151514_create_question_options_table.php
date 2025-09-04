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
        Schema::create(config('quiz.db_prefix') . 'question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained(config('quiz.db_prefix') . 'questions')->onDelete('cascade');
            $table->string('option_text')->nullable();
            $table->boolean('is_correct');
            $table->integer('position')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('quiz.db_prefix') . 'question_options');
    }
};
