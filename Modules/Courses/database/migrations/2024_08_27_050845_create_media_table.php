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

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mediable_id');
            $table->string('mediable_type');
            $table->string('type')->nullable(); // e.g., 'thumbnail', 'promotional_video', etc.
            $table->string('path', 510);
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
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'media');
    }
};
