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
        Schema::create(config('laraguppy.db_prefix'). ConfigurationManager::THREAD_DETAILS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('photo');
            $table->enum('allow_reply', ['yes', 'no']);
            $table->enum('thread_detail_status', ['active', 'inactive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix'). ConfigurationManager::THREAD_DETAILS_TABLE);
    }
};
