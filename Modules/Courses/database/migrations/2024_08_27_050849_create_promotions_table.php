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

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained((config('courses.db_prefix') ?? 'courses_')  . 'courses')->onDelete('cascade');
            $table->string('code');
            $table->date('valid_from');
            $table->date('valid_to');
            $table->string('color', 15);
            $table->integer('discount_percentage');
            $table->integer('maximum_users');
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
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'promotions');
    }
};
