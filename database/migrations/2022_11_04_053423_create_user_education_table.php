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
        Schema::create('user_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('course_title', 255)->fulltext();
            $table->string('institute_name', 255)->fulltext();
            $table->foreignId('country_id')->constrained();
            $table->string('city');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->tinyInteger('ongoing')->default(0);
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_education');
    }
};
