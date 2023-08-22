<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    protected $table = 'tbltransaction';
    protected $fillable = ['voucher', 'docnumber', 'reference', 'customer_id', 'encoded_by', 'supplier_id', 'tdate', 'amount'];
}
