<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    public function index()
    {

        $products = ProductsModel::all();

        return view('admin.products')->with('products', $products);
    }

    public function addproduct(Request $request)
    {
        $file = $request->file('image');

        $products = new ProductsModel();
        $products->image = $file->getClientOriginalName();
        $products->product_code = $request->product_code;
        $products->product_name = $request->product_name;

        $products->product_details = $request->product_details;
        $products->points = $request->product_points;
        $products->price = $request->product_price;
        $products->encoded_by = Auth::id();
        $products->save();

        $destinationPath = 'product_image';
        $file->move($destinationPath,$file->getClientOriginalName());

        return redirect('products');
    }

}
