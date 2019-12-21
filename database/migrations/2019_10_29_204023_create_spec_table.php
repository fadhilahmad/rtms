<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spec', function (Blueprint $table) {
            $table->bigIncrements('s_id');
            $table->unsignedBigInteger('o_id')->unsigned();   //order id
            $table->unsignedBigInteger('n_id')->unsigned();   //neck id
            $table->unsignedBigInteger('b_id')->unsigned();   //body id
            $table->unsignedBigInteger('sl_id')->unsigned();  //sleeve id
            $table->string('collar_color')->nullable();   //masuk color code
            $table->string('category')->nullable();
            $table->timestamps();
            
            $table->foreign('o_id')
                  ->references('o_id')
                  ->on('orders')
                  ->onDelete('cascade');
            
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
        Schema::dropIfExists('spec');
    }
}
