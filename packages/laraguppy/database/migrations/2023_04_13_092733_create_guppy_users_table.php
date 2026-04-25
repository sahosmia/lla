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
        Schema::create(config('laraguppy.db_prefix').ConfigurationManager::GP_USERS_TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->unique()->index();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists(config('laraguppy.db_prefix').ConfigurationManager::GP_USERS_TABLE);
    }
};
