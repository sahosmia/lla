<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->bigInteger('category_id')->index();
            $table->bigInteger('sub_category_id')->index();
            $table->json('tags')->nullable();
            $table->unsignedTinyInteger('type')->default(1);
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedTinyInteger('discussion_forum')->default(0);
            $table->unsignedBigInteger('language_id');
            $table->json('learning_objectives')->nullable();
            $table->text('prerequisites')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('content_length')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'courses');
    }
};
