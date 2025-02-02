<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionModel extends Model
{
    use HasFactory;

    protected $table = 'tblproduct_transaction';
    protected $fillable = ['voucher', 'docnumber', 'reference', 'product_id', 'PIn', 'POut', 'amount', 'piso_discount', 'refund', 'prv'];
}
