<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\DB;

class shoppingcart extends Controller
{
    //

    public function orderproduct()
    {
        $params = [];

        $params['products'] = ProductsModel::where('active', 1)->paginate(8);

        return view('customer.orderproducts')->with('params', $params);
    }

    public function orderproductdetails()
    {
        $params = [];

        $product_id = request()->id;

        $params['products'] = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_details', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproducts.id', $product_id)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->first();

        return view('customer.orderproductsdetails')->with('params', $params);
    }
}
