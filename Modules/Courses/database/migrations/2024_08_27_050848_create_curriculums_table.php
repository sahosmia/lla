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

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'curriculums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained((config('courses.db_prefix') ?? 'courses_')  . 'sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['video', 'audio', 'live', 'article'])->default('video');
            $table->string('media_path')->nullable();
            $table->text('article_content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('content_length')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_preview')->default(false);
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
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'curriculums');
    }
};
