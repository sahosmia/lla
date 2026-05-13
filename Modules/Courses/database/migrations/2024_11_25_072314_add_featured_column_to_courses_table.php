<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'courses', function (Blueprint $table) {
            $table->after('tags', function ($table) {
                $table->boolean('featured')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable((config('courses.db_prefix') ?? 'courses_')  . 'courses')) {
            Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'courses', function (Blueprint $table) {
                $table->dropColumn('featured');
            });
        }
    }
};
