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
            $table->unsignedBigInteger('n_id')->unsigned();   //neck id
            $table->unsignedBigInteger('b_id')->unsigned();   //body id
            $table->unsignedBigInteger('sl_id')->unsigned();  //sleeve id
            $table->integer('price');
            $table->timestamps();
            
            $table->foreign('n_id')
                  ->references('n_id')
                  ->on('neck')
                  ->onDelete('cascade');
            
            $table->foreign('b_id')
                  ->references('b_id')
                  ->on('body')
                  ->onDelete('cascade');
            
            $table->foreign('sl_id')
                  ->references('sl_id')
                  ->on('sleeve')
                  ->onDelete('cascade'); 
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
