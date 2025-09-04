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
        Schema::create(config('upcertify.db_prefix').'templates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200)->fulltext();
            $table->json('body')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 for draft, 1 for publish');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('upcertify.db_prefix').'templates');
    }
};
