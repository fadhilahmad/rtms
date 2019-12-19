<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBlockday extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_day', function (Blueprint $table) {
            $table->bigIncrements('bd_id');
            $table->string('day')->nullable();
            $table->integer('bd_status')->nullable();   //1 for blocked, 0 for unblocked
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
        Schema::dropIfExists('block_day');
    }
}
