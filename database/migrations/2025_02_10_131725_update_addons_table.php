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
        Schema::table('addons', function (Blueprint $table) {
            $table->string('description')->nullable()->after('slug');
            $table->string('image')->nullable()->after('slug');
            $table->dropColumn('type');
            $table->json('meta_data')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addons', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->tinyInteger('type')->default(0)->comment('0: free, 1: paid');
            $table->dropColumn('image');
        });
    }
};
