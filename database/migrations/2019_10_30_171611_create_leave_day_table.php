<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_day', function (Blueprint $table) {
            $table->bigIncrements('ld_id');
            $table->unsignedBigInteger('u_id')->unsigned();
            $table->integer('al_day');
            $table->integer('el_day');
            $table->integer('mc_day');
            $table->timestamps();
            
            $table->foreign('u_id')
                  ->references('u_id')
                  ->on('user')
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
        Schema::dropIfExists('leave_day');
    }
}
