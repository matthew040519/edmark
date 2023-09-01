<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
{
    use HasFactory;

    protected $table = 'tblapplication';
    protected $fillable = ['application_id', 'customer_id', 'product_id', 'qty', 'amount', 'piso_discount', 'percent_discount', 'checkout'];
}
