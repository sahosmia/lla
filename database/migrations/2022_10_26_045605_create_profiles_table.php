<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('first_name', 150)->fulltext('first_name');
            $table->string('last_name', 150)->fulltext('last_name');
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('recommend_tutor')->default(0);
            $table->string('slug')->index();
            $table->string('image')->nullable();
            $table->string('intro_video')->nullable();
            $table->string('native_language',255)->nullable();
            $table->string('tagline')->nullable()->fulltext('tagline');
            $table->text('description')->nullable()->fulltext('description');
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('feature_expired_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_profiles');
    }
};

