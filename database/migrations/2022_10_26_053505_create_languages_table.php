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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->fullText();
            $table->text('description')->nullable()->fullText();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
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
        Schema::dropIfExists('languages');
    }
};
