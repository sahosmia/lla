<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        if (!Schema::hasTable($prefix . 'training_notices')) {
            Schema::create($prefix . 'training_notices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('training_calendar_id')->index();
                $table->unsignedBigInteger('sent_by')->index();
                $table->string('subject');
                $table->text('message')->nullable();
                $table->string('zoom_link')->nullable();
                $table->string('meet_link')->nullable();
                $table->string('location')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(config('trainingcalendar.db_prefix', 'training_calendar_') . 'training_notices');
    }
};
