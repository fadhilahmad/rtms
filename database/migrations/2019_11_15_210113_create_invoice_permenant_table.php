<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePermenantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_permenant', function (Blueprint $table) {
            $table->bigIncrements('ip_id');
            $table->unsignedBigInteger('i_id')->unsigned();
            $table->unsignedBigInteger('s_id')->unsigned();
            $table->integer('price_unit');
            $table->integer('quantity');
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
        Schema::dropIfExists('invoice_permenant');
    }
}
