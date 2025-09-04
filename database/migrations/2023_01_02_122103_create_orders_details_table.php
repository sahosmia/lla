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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('student_id')->unsigned()->index();
            $table->double('amount', 10, 2);
            $table->string('transaction_id')->nullable();
            $table->double('used_wallet_amt', 10, 2)->default(0);
            $table->double('sales_tax', 10, 2)->default(0);
            $table->string('currency', 100);
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('company', 150);
            $table->string('country', 150);
            $table->string('state', 150);
            $table->string('postal_code', 150);
            $table->string('city', 150);
            $table->string('phone', 150);
            $table->string('email', 150);
            $table->string('payment_method', 150)->nullable();
            $table->text('description')->nullable()->fulltext('description');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
};
