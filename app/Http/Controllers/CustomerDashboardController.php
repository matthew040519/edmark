<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;

class CustomerDashboardController extends Controller
{
    //
    public function index()
    {

        $products = ProductsModel::all();

        return view('customer.customerdashboard')->with('products', $products);
    }
}
