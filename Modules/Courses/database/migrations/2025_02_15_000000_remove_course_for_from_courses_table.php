<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableName = (config('courses.db_prefix') ?? 'courses_') . 'courses';

        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columnsToDrop = [];
                foreach (['course_for', 'venue', 'date', 'time'] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $columnsToDrop[] = $column;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });

            // Convert existing validity_type data to integers if they are still strings
            DB::table($tableName)->where('validity_type', 'days')->update(['validity_type' => 1]);
            DB::table($tableName)->where('validity_type', 'months')->update(['validity_type' => 2]);
            DB::table($tableName)->where('validity_type', 'years')->update(['validity_type' => 3]);

            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedTinyInteger('validity_type')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = (config('courses.db_prefix') ?? 'courses_') . 'courses';

        Schema::table($tableName, function (Blueprint $table) {
            $table->tinyInteger('course_for')->default(1)->comment('1: online, 2: classroom');
            $table->string('venue')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('validity_type')->nullable()->change();
        });

        DB::table($tableName)->where('validity_type', 1)->update(['validity_type' => 'days']);
        DB::table($tableName)->where('validity_type', 2)->update(['validity_type' => 'months']);
        DB::table($tableName)->where('validity_type', 3)->update(['validity_type' => 'years']);
    }
};
