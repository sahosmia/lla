<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained((config('courses.db_prefix') ?? 'courses_')  . 'courses');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'sections');
    }
};
