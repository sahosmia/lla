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
        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('course_id');
            $table->decimal('course_price', 8, 2)->nullable()->default(0.00);
            $table->decimal('course_discount', 8, 2)->nullable()->default(0.00);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'enrollments');
    }
};
