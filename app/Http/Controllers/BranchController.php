<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchModel;

class BranchController extends Controller
{
    //
    public function index()
    {

        $branch = BranchModel::all();


        return view('admin.branch')->with('branch', $branch);
    }
}
