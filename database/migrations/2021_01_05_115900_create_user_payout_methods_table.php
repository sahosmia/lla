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
        Schema::create('user_payout_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('payout_method', ['paypal', 'payoneer', 'bank'])->nullable();
            $table->json('payout_details')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->unique(['user_id', 'payout_method']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_payout_methods');
    }
};
