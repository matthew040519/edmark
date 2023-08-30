<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;

    protected $table = 'tblcustomer';
    protected $fillable = ['firstname', 'middlename', 'lastname', 'contact_number', 'bday', 'address', 'encoded_date', 'encoded_by', 'email', 'password'];
}
