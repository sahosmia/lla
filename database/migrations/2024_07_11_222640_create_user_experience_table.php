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
        Schema::create('user_experience', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('employment_type')->comment('1-> full time, 2-> part time, 3-> self employed,  4-> Contract');
            $table->string('company');
            // $table->string('location');
            $table->enum('location',['onsite','remote', 'hybrid']);
            $table->foreignId('country_id')->constrained();
            $table->string('city');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_experience');
    }
};
