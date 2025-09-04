<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('pagebuilder.db_prefix') . 'pages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fullText();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->longText('settings')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('pagebuilder.db_prefix') . 'pages');
    }
}
