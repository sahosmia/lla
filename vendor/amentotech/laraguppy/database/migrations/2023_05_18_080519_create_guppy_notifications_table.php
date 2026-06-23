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
        Schema::create(config('laraguppy.db_prefix').ConfigurationManager::NOTIFICATIONS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('message_id')->index();
            $table->unsignedBigInteger('notificationable_id')->index();
            $table->string('notificationable_type')->index();
            $table->enum('notification_type', ['accept_friend',  'block_friend'])->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix').ConfigurationManager::NOTIFICATIONS_TABLE);
    }
};
