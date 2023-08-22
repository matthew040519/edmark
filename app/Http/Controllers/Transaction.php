<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\SupplierModel;
use App\Models\ProductsModel;
use App\Models\TempProductModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transaction extends Controller
{
    //
    public function PurchaseProducts()
    {
        $supplier = SupplierModel::all();
        $products = ProductsModel::all();

        $params = [];

        $temp_product = TempProductModel::select('tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.PIn - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->get();

        $params['supplier'] = $supplier;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        $params['total'] = $temp_product->sum('total');

        // function generateRandomNumber() {

        //     $number = mt_rand(1000000000, 9999999999);

        //     if (randomNumberExists($number)) {
        //         return generateRandomNumber();
        //     }

        //     return $number;
        // }

        // function randomNumberExists($number) {
        //     return TransactionModel::where('reference', $number)->exists();
        // }

        return view('admin.purchase')->with('params', $params);
    }

    public function insertTemp(Request $request)
    {
        $TempProductModel = new TempProductModel();

        $productamount = ProductsModel::select('price')->where('id', $request->product_id)->first();

        $TempProductModel->product_id = $request->product_id;
        $TempProductModel->PIn = $request->qty;
        $TempProductModel->POut = 0;
        $TempProductModel->amount = $productamount->price;
        $TempProductModel->piso_discount = $request->peso_discount;
        $TempProductModel->user_id = Auth::id();
        $TempProductModel->save();

        return redirect('purchase-products');
    }

    public function insert_purchases(Request $request)
    {
        // dd($request->all());
        $transaction = new TransactionModel();

        $randomNum = 0;

        function generateRandomNumber() {

            $number = mt_rand(1000000000, 9999999999);

            if (randomNumberExists($number)) {
                return generateRandomNumber();
            }

            return $number;
        }

        function randomNumberExists($number) {
            return TransactionModel::where('reference', $number)->exists();
        }

        $randomNum = generateRandomNumber();

        

        $transaction->voucher = 'PS';
        $transaction->docnumber = 'PS'.$randomNum."|".Auth::id();
        $transaction->reference = $randomNum;
        $transaction->encoded_by = Auth::id();
        $transaction->supplier_id = $request->supplier;
        $transaction->tdate = $request->tdate;
        $transaction->amount = intval($request->amount);
        $transaction->save();

        $temp_product = TempProductModel::where('user_id', Auth::id())->get();
        foreach($temp_product as $temp_products)
        {
            $product_transaction = new ProductTransactionModel();
            $product_transaction->voucher = 'PS';
            $product_transaction->docnumber = 'PS'.$randomNum."|".Auth::id();
            $product_transaction->reference = $randomNum;
            $product_transaction->product_id = $temp_products->product_id;
            $product_transaction->PIn = $temp_products->PIn;
            $product_transaction->POut = 0;
            $product_transaction->amount = $temp_products->amount * $temp_products->PIn;
            $product_transaction->piso_discount = $temp_products->piso_discount;
            $product_transaction->save();

            TempProductModel::where('id', $temp_products->id)->delete();
        }

        return redirect('purchase-products');
    }

    
}
