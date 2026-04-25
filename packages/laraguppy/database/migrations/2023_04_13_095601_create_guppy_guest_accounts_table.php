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
        Schema::create(config('laraguppy.db_prefix'). ConfigurationManager::GUEST_ACCOUNTS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('laraguppy.db_prefix'). ConfigurationManager::GUEST_ACCOUNTS_TABLE);
    }
};
