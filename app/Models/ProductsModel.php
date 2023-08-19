<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table =  'tblproducts';
    protected $fillable = ['image', 'product_code', 'product_name', 'points', 'price', 'encoded_by', 'active'];

}
