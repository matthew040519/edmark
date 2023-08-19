<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    use HasFactory;

    protected $table = 'tblbranch';
    protected $fillable = ['branch_name', 'address'];
}
