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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('date_time')->nullable();
            $table->dateTime('sort_date')->nullable();
            $table->string('mode')->nullable(); // Virtual or Physical
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Tutor (creator)
            $table->string('banner_image')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('venue_city')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->dateTime('registration_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
