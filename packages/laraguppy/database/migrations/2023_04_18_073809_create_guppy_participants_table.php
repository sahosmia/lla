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
        Schema::create(config('laraguppy.db_prefix'). ConfigurationManager::PARTICIPANTS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('thread_id')->index();
            $table->unsignedBigInteger('participantable_id')->index();
            $table->string('participantable_type')->index();
            $table->dateTime('last_read')->nullable();
            $table->enum('role', ['creator', 'admin', 'user'])->index();
            $table->enum('participant_status', ['active', 'left', 'blocked'])->default(ConfigurationManager::ACTIVE_STATUS);
            $table->unsignedBigInteger('blocked_by')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix'). ConfigurationManager::PARTICIPANTS_TABLE);
    }
};
