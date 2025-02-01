<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BestBuyProduct extends Model
{
    use HasFactory;

    protected $table = 'tblbestbuyproduct';

    protected $fillable = [
        'bestbuy_stamp_code',
        'stamp_name',
        'stamp_quantity',
        'dp',
        'sv',
        'bv',
        'cp'
    ];

}
