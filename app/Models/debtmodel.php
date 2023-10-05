<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class debtmodel extends Model
{
    use HasFactory;

    protected $table = 'tbldebt';
    protected $fillable = ['voucher', 'reference_id', 'credit', 'debit', 'rownum'];
}
