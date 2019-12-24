<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('o_id');           
            $table->string('file_name')->nullable();
//            $table->string('category')->nullable();
            $table->unsignedBigInteger('material_id')->unsigned()->nullable();       //baca dari table material
            $table->integer('quantity_total');
            $table->text('note')->nullable();
            $table->text('designer_note')->nullable();
            $table->text('design_link')->nullable();
            $table->text('delivery_type')->nullable();
            $table->string('ref_num')->nullable();
            $table->date('delivery_date');
            $table->integer('o_status')->nullable();
            $table->unsignedBigInteger('u_id_customer')->unsigned();
            $table->unsignedBigInteger('u_id_designer')->unsigned()->nullable();
            $table->unsignedBigInteger('u_id_print')->unsigned()->nullable();
            $table->unsignedBigInteger('u_id_taylor')->unsigned()->nullable();
            $table->integer('balance')->nullable();
            $table->integer('active')->nullable();
            $table->timestamps();
            
//            $table->foreign('material_id')->references('m_id')->on('material')->onDelete('cascade');
//            $table->foreign('u_id_customer')->references('u_id')->on('user')->onDelete('cascade');
//            $table->foreign('u_id_designer')->references('u_id')->on('user')->onDelete('cascade');
//            $table->foreign('u_id_print')->references('u_id')->on('user')->onDelete('cascade');
//            $table->foreign('u_id_taylor')->references('u_id')->on('user')->onDelete('cascade');
        });

             
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
