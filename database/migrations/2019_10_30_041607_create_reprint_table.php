<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReprintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reprint', function (Blueprint $table) {
            $table->bigIncrements('r_id');
            $table->unsignedBigInteger('un_id')->unsigned();
            $table->integer('r_quantity');
            $table->integer('r_status');              
            $table->timestamps();
            
            $table->foreign('un_id')
                  ->references('un_id')
                  ->on('unit')
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
        Schema::dropIfExists('reprint');
    }
}
