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
        Schema::create(config('upcertify.db_prefix').'media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->fulltext();
            $table->string('path')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0 for attachment, 1 for background, 2 for thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('upcertify.db_prefix').'media');
    }
};
