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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->morphs('disputable');
            $table->foreignId('responsible_by')->constrained('users');
            $table->foreignId('creator_by')->constrained('users');
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            $table->foreignId('favour_to')->nullable()->constrained('users');
            $table->string('dispute_reason')->fulltext('dispute_reason');
            $table->text('dispute_detail');
            $table->string('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
