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
    public function up() {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->morphs('ratingable');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('tutor_id')->constrained('users');
            $table->tinyInteger('rating')->default(0);
            $table->string('image')->nullable();
            $table->mediumText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ratings');
    }
};
