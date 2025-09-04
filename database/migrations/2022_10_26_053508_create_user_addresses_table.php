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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('addressable_id');
            $table->string('addressable_type')->fulltext();
            $table->foreignId('country_id')->constrained();
            $table->foreignId('state_id')->nullable()->constrained('country_states');
            $table->string('city')->nullable()->fulltext();
            $table->string('address')->nullable()->fulltext();
            $table->string('zipcode')->nullable()->fulltext();
            $table->decimal('lat', 8, 6, true)->unsigned(false)->default(0);
            $table->decimal('long', 9, 6, true)->unsigned(false)->default(0);
            $table->timestamps();
            $table->index(['addressable_id', 'addressable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_addresses');
    }
};
