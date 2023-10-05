<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbldebt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbldebt', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->string('reference_id');
            $table->integer('credit');
            $table->integer('debit');
            $table->integer('rownum');
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
        Schema::dropIfExists('tbldebt');
    }
}
