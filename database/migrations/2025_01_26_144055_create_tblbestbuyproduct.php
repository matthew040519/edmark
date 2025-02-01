<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblbestbuyproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblbestbuyproduct', function (Blueprint $table) {
            $table->id();
            $table->string('bestbuy_stamp_code');
            $table->string('stamp_name');
            $table->integer('stamp_quantity');
            $table->decimal('dp', 8, 2);
            $table->decimal('sv', 8, 2);
            $table->decimal('bv', 8, 2);
            $table->decimal('cp', 8, 2);
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
        Schema::dropIfExists('tblbestbuyproduct');
    }
}
