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
        Schema::create(config('laraguppy.db_prefix') . ConfigurationManager::ATTACHMENTS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('message_id')->index();
            $table->json('attachments');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists(config('laraguppy.db_prefix') . ConfigurationManager::ATTACHMENTS_TABLE);
    }
};
