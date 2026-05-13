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
        $dbPrefix = config('courses.db_prefix') ?? 'courses_';

        Schema::create($dbPrefix . 'classroom_training_submissions', function (Blueprint $table) use ($dbPrefix) {
            $table->id();
            $table->foreignId('course_id')->constrained($dbPrefix . 'courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('profession');
            $table->string('organization');
            $table->text('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dbPrefix = config('courses.db_prefix') ?? 'courses_';
        Schema::dropIfExists($dbPrefix . 'classroom_training_submissions');
    }
};
