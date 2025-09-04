<?php

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('laraguppy.db_prefix').ConfigurationManager::SEEN_MESSAGES_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thread_id')->index();
            $table->unsignedBigInteger('message_id')->index();
            $table->unsignedBigInteger('seen_by')->index();
            $table->timestamp('seen_at')->nullable();
            $table->unique(['thread_id', 'message_id', 'seen_by']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix').ConfigurationManager::SEEN_MESSAGES_TABLE);
    }
};
