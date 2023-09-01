<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblapplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblapplication', function (Blueprint $table) {
            $table->id();
            $table->string('application_id');
            $table->string('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->integer('amount');
            $table->integer('piso_discount');
            $table->integer('percent_discount');
            $table->integer('checkout')->default('0');
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
        Schema::dropIfExists('tblapplication');
    }
}
