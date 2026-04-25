<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'curriculums', function (Blueprint $table) {
            $table->enum('type', ['video', 'audio', 'live', 'article', 'yt_link', 'vm_link'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        if (Schema::hasTable((config('courses.db_prefix') ?? 'courses_')  . 'curriculums')) {
            Schema::table((config('courses.db_prefix') ?? 'courses_')  . 'curriculums', function (Blueprint $table) {
                DB::table((config('courses.db_prefix') ?? 'courses_')  . 'curriculums')->truncate();
                $table->enum('type', ['video', 'audio', 'live', 'article'])->change();
            });
        }
    }
};
