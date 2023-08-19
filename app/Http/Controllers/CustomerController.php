<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;

class CustomerController extends Controller
{
    //

    public function index()
    {
        $customer = CustomerModel::all();

        return view('admin.customer')->with('customer', $customer);
    }
}
