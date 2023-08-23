<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductSetupModel;

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

    public function productsetup()
    {   
        $params = [];

        $params['products'] = ProductsModel::all();

        $params['productsetup'] = ProductSetupModel::select('a.product_name as aproduct', 'b.product_name as bproduct', 'tblproductsetup.amount', 'tblproductsetup.qty')->join('tblproducts as a', 'a.id', 'tblproductsetup.product_id')->join('tblproducts as b', 'b.id', 'tblproductsetup.free_product_id')->get();

        // dd($productsetup);  

        return view('admin.productsetup')->with('params', $params);
    }

    public function addproductsetup(Request $request)
    {

        $ProductSetupModel = new ProductSetupModel();
        $ProductSetupModel->product_id = $request->product_id;
        $ProductSetupModel->free_product_id = $request->free_product_id;
        $ProductSetupModel->qty = $request->qty;
        $ProductSetupModel->amount = $request->product_price;
        $ProductSetupModel->save();

        return redirect('products-setup');
    }
}
