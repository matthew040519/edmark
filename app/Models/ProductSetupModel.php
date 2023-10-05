<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSetupModel extends Model
{
    use HasFactory;

    protected $table = 'tblproductsetup';
    protected $fillable = ['product_id', 'p_qty', 'free_product_id', 'qty', 'amount'];
}
