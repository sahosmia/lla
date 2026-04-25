<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disputes', function (Blueprint $table) {
            $table->unsignedBigInteger('winner_id')->nullable()->after('dispute_detail'); 
        });
    }
    
    public function down()
    {
        Schema::table('disputes', function (Blueprint $table) {
            $table->dropColumn('winner_id');
        });
    }
    
    
};
