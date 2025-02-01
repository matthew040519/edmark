<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestBuyProductProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblbest_buy_product_products', function (Blueprint $table) {
            $table->id();
            $table->string('bestbuy_stamp_code');
            $table->integer('product_id');
            $table->integer('free_product_id');
            $table->decimal('amount',  8, 2)->default(0);
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
        Schema::dropIfExists('best_buy_product_products');
    }
}
