<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::create($prefix . 'training_calendars', function (Blueprint $table) use ($prefix) {
            $table->id();
            $table->unsignedBigInteger('tutor_id')->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('type', 20)->default('online');
            $table->string('venue')->nullable();
            $table->dateTime('registration_deadline');
            $table->dateTime('event_datetime');
            $table->unsignedInteger('max_seats')->default(50);
            $table->string('status', 20)->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($prefix . 'training_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_calendar_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('profession')->nullable();
            $table->string('payment_status', 20)->default('paid');
            $table->timestamps();
        });

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

    public function down(): void
    {
        $prefix = config('trainingcalendar.db_prefix', 'training_calendar_');

        Schema::dropIfExists($prefix . 'training_notices');
        Schema::dropIfExists($prefix . 'training_registrations');
        Schema::dropIfExists($prefix . 'training_calendars');
    }
};
