<?php

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
        Schema::create('booking_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activityable_id');
            $table->foreignId('booking_id')->constrained('slot_bookings');
            $table->string('activityable_type')->fulltext();
            $table->tinyInteger('type')->default(1)->comment('1-> Booked, 2-> Reschedule, 3-> Refuned');
            $table->timestamps();
            $table->index(['activityable_id', 'activityable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_logs');
    }
};
