<?php

use Amentotech\LaraGuppy\ConfigurationManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create(config('laraguppy.db_prefix') . ConfigurationManager::FRIENDS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->unsignedInteger('friend_id')->index();
            $table->unique(['user_id', 'friend_id']);
            $table->enum('friend_status', ['invited', 'active', 'declined', 'blocked', 'invite_blocked'])->index();
            $table->bigInteger('blocked_by')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists(config('laraguppy.db_prefix') . ConfigurationManager::FRIENDS_TABLE);
    }
};
