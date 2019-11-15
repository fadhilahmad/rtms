<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price', function (Blueprint $table) {
            $table->bigIncrements('p_id');
            $table->unsignedBigInteger('n_type')->unsigned();   //neck id
            $table->unsignedBigInteger('b_id')->unsigned();   //body id
            $table->unsignedBigInteger('sl_id')->unsigned();  //sleeve id
            $table->unsignedBigInteger('u_type')->unsigned()->nullable;
            $table->integer('price');
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
        Schema::dropIfExists('price');
    }
}
