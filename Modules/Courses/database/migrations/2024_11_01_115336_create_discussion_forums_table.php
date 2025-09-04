<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create((config('courses.db_prefix') ?? 'courses_') . 'discussion_forums', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->foreignId('course_id')->constrained((config('courses.db_prefix') ?? 'courses_') . 'courses')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained((config('courses.db_prefix') ?? 'courses_') . 'discussion_forums')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_') . 'discussion_forums');
    }
};
