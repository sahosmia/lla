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
        Schema::create(config('laraguppy.db_prefix') . ConfigurationManager::CHAT_ACTIONS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('actionable_id')->index();
            $table->string('actionable_type')->index();
        
            $table->enum(
                'action',
                [
                    'clear_chat',
                    'mute_notifications',
                    'group_left',
                    'removed_from_group',
                    'group_delete'
                ]
            )->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists(config('laraguppy.db_prefix') . ConfigurationManager::CHAT_ACTIONS_TABLE);
    }
};
