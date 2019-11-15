<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('neck', function (Blueprint $table) {
            $table->bigIncrements('n_id');
            $table->string('n_desc')->nullable();
            $table->integer('n_type')->nullable();
            $table->integer('n_status')->nullable();
            $table->string('n_url')->nullable();    //image url
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
        Schema::dropIfExists('neck');
    }
}
