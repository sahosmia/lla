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
        Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'courses', function (Blueprint $table) {
            $table->json('meta_data')->nullable()->after('views_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'courses', function (Blueprint $table) {
            $table->dropColumn('meta_data');
        });
    }
};
