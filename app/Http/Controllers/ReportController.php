<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSetupModel;
use App\Models\ProductsModel;

class ReportController extends Controller
{
    //
    public function inventory()
    {
        $params = [];

        $params['products'] = ProductsModel::all();

        $params['productsetup'] = ProductSetupModel::select('a.product_name as aproduct', 'b.product_name as bproduct', 'tblproductsetup.amount', 'tblproductsetup.qty')->join('tblproducts as a', 'a.id', 'tblproductsetup.product_id')->join('tblproducts as b', 'b.id', 'tblproductsetup.free_product_id')->get();

        // dd($productsetup);  

        return view('admin.inventory')->with('params', $params);
    }
}
