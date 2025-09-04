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
        Schema::create('user_identity_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name', 100)->fulltext();
            $table->date('dob')->nullable();
            $table->string('school_id', 100)->nullable();
            $table->string('school_name', 255)->nullable();
            $table->string('transcript', 255)->nullable();
            $table->string('parent_name', 100)->nullable();
            $table->string('parent_phone', 100)->nullable();
            $table->string('parent_email', 100)->nullable();
            $table->string('personal_photo', 255);
            $table->tinyInteger('status')->default(0);
            $table->json('attachments')->nullable();
            $table->timestamp('parent_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_identity_verifications');
    }
};
