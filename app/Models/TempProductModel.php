<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempProductModel extends Model
{
    use HasFactory;

    protected $table = 'tbltempproduct';
    protected $fillable = ['voucher', 'product_id', 'PIn', 'POut', 'amount', 'piso_discount', 'user_id'];
}
