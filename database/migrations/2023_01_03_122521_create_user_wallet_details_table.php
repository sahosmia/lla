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
        Schema::create('user_wallet_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_wallet_id')->constrained();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->tinyInteger('type')->default(0)->comment('1-> Adding Funds, 2-> Deducted Funds via withdrawn, 3-> Deduct via Refund, 4-> Pending for Available');
            $table->double('amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_wallet_details');
    }
};
