<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblproductTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblproduct_transaction', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->string('docnumber');
            $table->string('reference');
            $table->unsignedBigInteger('product_id');

            $table->integer('PIn');
            $table->integer('POut');
            $table->integer('amount');
            $table->integer('piso_discount');
            $table->integer('percent_discount');

            $table->timestamps();

            $table->foreign('product_id')
              ->references('id')->on('tblproducts')->onDelete('cascade');

            $table->unique(['docnumber']);
            $table->unique(['reference']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblproduct_transaction');
    }
}
