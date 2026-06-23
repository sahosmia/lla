<?php

use Amentotech\LaraGuppy\ConfigurationManager;
use Doctrine\DBAL\Configuration;
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
        Schema::create(config('laraguppy.db_prefix') . ConfigurationManager::THREADS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('thread_type', [ConfigurationManager::PRIVATE, ConfigurationManager::GROUP])->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix') . ConfigurationManager::THREADS_TABLE);
    }
};
