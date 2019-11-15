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
            $table->unsignedBigInteger('s_id')->unsigned();
            $table->unsignedBigInteger('o_id')->unsigned();          
            $table->integer('spec_total_price');
            $table->integer('one_unit_price');
            $table->integer('spec_total_quantity');
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
