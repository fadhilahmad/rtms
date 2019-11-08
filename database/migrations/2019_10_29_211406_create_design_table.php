<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('o_id')->unsigned();
            $table->unsignedBigInteger('un_id')->unsigned()->nullable();
            $table->unsignedBigInteger('u_id_designer')->unsigned();
            $table->string('d_url')->nullable();  //image url
            $table->integer('d_type');
            $table->timestamps();
            
            $table->foreign('o_id')
                  ->references('o_id')
                  ->on('orders')
                  ->onDelete('cascade');
            
//            $table->foreign('un_id')
//                  ->references('un_id')
//                  ->on('unit')
//                  ->onDelete('cascade');
            
//            $table->foreign('u_id_designer')
//                  ->references('u_id')
//                  ->on('user')
//                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('design');
    }
}
