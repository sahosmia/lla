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

        Schema::create((config('courses.db_prefix') ?? 'courses_')  . 'pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained((config('courses.db_prefix') ?? 'courses_')  . 'courses');
            $table->decimal('price', 8, 2)->default(0.00);
            $table->tinyInteger('discount')->nullable();
            $table->decimal('final_price', 8, 2)->default(0.00);
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
        Schema::dropIfExists((config('courses.db_prefix') ?? 'courses_')  . 'pricings');
    }
};
