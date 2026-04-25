<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Full Name 
            $table->string('email'); // Email Address 
            $table->string('phone'); // Contact Number 
            $table->string('organization')->nullable(); // Organization/University 
            $table->string('designation')->nullable(); // Designation 
            $table->string('inquiry_type'); // Type of Inquiry 
            $table->text('message')->nullable(); // Message 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};