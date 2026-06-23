<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = (config('courses.db_prefix') ?? 'courses_') . 'enrollments';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn($tableName, 'last_curriculum_id')) {
                $table->unsignedBigInteger('last_curriculum_id')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn($tableName, 'last_accessed_at')) {
                $table->timestamp('last_accessed_at')->nullable()->after('last_curriculum_id');
            }
        });
    }

    public function down(): void
    {
        $tableName = (config('courses.db_prefix') ?? 'courses_') . 'enrollments';

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            $columns = array_filter([
                Schema::hasColumn($tableName, 'last_accessed_at') ? 'last_accessed_at' : null,
                Schema::hasColumn($tableName, 'last_curriculum_id') ? 'last_curriculum_id' : null,
                Schema::hasColumn($tableName, 'completed_at') ? 'completed_at' : null,
            ]);

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
