<?php

use Amentotech\LaraGuppy\ConfigurationManager;
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
        Schema::create(config('laraguppy.db_prefix').ConfigurationManager::MESSAGES_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('thread_id')->index();
            $table->unsignedBigInteger('messageable_id')->index();
            $table->string('messageable_type')->index();
            $table->text('body')->nullable();
            $table->unsignedInteger('parent_message_id')->nullable()->index();
            $table->enum('message_type', ['text' ,'audio', 'video', 'voice', 'image', 'document', 'location', 'notify'])->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix').ConfigurationManager::MESSAGES_TABLE);
    }
};
