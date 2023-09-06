<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;

class LandingController extends Controller
{
    //
    public function products()
    {
        $products = ProductsModel::where('active', 1)->get();

        return view('products')->with('products', $products);
    }
}
