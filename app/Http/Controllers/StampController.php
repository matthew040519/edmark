<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\ProductsModel;
use App\Models\TempProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StampController extends Controller
{
    //
    public function redeemstamp()
    {
        $customer = CustomerModel::all();
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tbltransaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->where([ ['tblproduct_transaction.refund', 0], ['tblproduct_transaction.voucher', '!=', 'AI'], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tbltransaction.status', 1]])->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.image', 'tblproducts.price', 'tblproducts.id'])->get();

        $params = [];

        $temp_product = TempProductModel::select('tbltempproduct.id', 'tbltempproduct.free', 'tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.POut', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.POut - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where('voucher', 'RSP')->get();

        $params['customer'] = $customer;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        $params['total'] = $temp_product->sum('total');
        
        return view('admin.redeemstamp')->with('params', $params);
    }
}
