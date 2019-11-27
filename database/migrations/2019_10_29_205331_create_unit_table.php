<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->bigIncrements('un_id');
            $table->unsignedBigInteger('o_id')->unsigned();
            $table->unsignedBigInteger('s_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('size')->nullable();
            $table->integer('un_quantity');
            $table->unsignedBigInteger('u_id_designer')->unsigned()->nullable();
            $table->unsignedBigInteger('u_id_print')->unsigned()->nullable();
            $table->unsignedBigInteger('u_id_taylor')->unsigned()->nullable();
            $table->integer('sewed')->default('0');
            $table->integer('delivered')->default('0');
            $table->integer('un_status')->nullable();
            $table->timestamps();
            
            $table->foreign('o_id')
                  ->references('o_id')
                  ->on('orders')
                  ->onDelete('cascade');
            
            // $table->foreign('s_id')
            //       ->references('s_id')
            //       ->on('spec')
            //       ->onDelete('cascade');
            
//            $table->foreign('u_id_print')
//                  ->references('u_id')
//                  ->on('user')
//                  ->onDelete('cascade');
//            
//            $table->foreign('u_id_taylor')
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
        Schema::dropIfExists('unit');
    }
}
