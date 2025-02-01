<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestBuyProduct_products extends Model
{
    use HasFactory;

    protected $table = 'tblbest_buy_product_products';

    protected $fillable = [
        'bestbuy_stamp_code',
        'product_id',
        'free_product_id',
        'amount',
    ];
}
