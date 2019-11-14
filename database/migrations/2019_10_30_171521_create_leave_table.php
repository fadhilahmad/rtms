<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave', function (Blueprint $table) {
            $table->bigIncrements('l_id');
            $table->unsignedBigInteger('u_id')->unsigned();
            $table->text('reason')->nullable();
            $table->integer('l_type');
            $table->integer('l_status');
            $table->integer('total_day');
            $table->text('file_url')->nullable();
            $table->date('apply_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('approve_date');
            $table->date('updated_date');
            
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
        Schema::dropIfExists('leave');
    }
}
