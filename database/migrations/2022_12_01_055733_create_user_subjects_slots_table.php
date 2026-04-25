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
        Schema::create('user_subject_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_subject_group_subject_id')->constrained('user_subject_group_subjects');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('spaces')->default(0);
            $table->integer('duration')->default(0);
            $table->integer('total_booked')->default(0);
            $table->double('session_fee');
            $table->tinyInteger('type')->default(0);
            $table->text('description')->nullable();
            $table->json('meta_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_subject_slots');
    }
};
