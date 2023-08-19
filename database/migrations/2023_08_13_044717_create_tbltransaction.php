<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbltransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbltransaction', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->string('docnumber');
            $table->string('reference');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('encoded_by');
            $table->string('tdate');
            $table->integer('amount');
            $table->foreign('encoded_by')
              ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')
              ->references('id')->on('tblcustomer')->onDelete('cascade');
            $table->timestamps();

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
        Schema::dropIfExists('tbltransaction');
    }
}
