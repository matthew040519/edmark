<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\SupplierModel;
use App\Models\CustomerModel;
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

        $temp_product = TempProductModel::select('tbltempproduct.id', 'tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.PIn - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where('voucher', 'PS')->get();

        $params['supplier'] = $supplier;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        $params['total'] = $temp_product->sum('total');

        return view('admin.purchase')->with('params', $params);
    }

    public function BuyProducts()
    {
        $customer = CustomerModel::all();
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price'])->get();

        $params = [];

        $temp_product = TempProductModel::select('tbltempproduct.id','tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.POut', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.POut - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where('voucher', 'CS')->get();

        $params['customer'] = $customer;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        $params['total'] = $temp_product->sum('total');
        
        return view('admin.buyproduct')->with('params', $params);
    }

    public function insertTemp(Request $request)
    {
        $TempProductModel = new TempProductModel();

        $productamount = ProductsModel::select('price')->where('id', $request->product_id)->first();

        $TempProductModel->product_id = $request->product_id;
        $TempProductModel->voucher = $request->voucher;
        if($request->voucher == 'PS')
        {
                $TempProductModel->PIn = $request->qty;
                $TempProductModel->POut = 0;
        }
        else
        {
                $TempProductModel->POut = $request->qty;
                $TempProductModel->PIn = 0;
        }
        
        $TempProductModel->amount = $productamount->price;
        $TempProductModel->piso_discount = $request->peso_discount;
        $TempProductModel->user_id = Auth::id();
        $TempProductModel->save();

        return redirect($request->link);
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

        

        $transaction->voucher = $request->voucher;
        $transaction->docnumber = $request->voucher.$randomNum."|".Auth::id();
        $transaction->reference = $randomNum;
        $transaction->encoded_by = Auth::id();
        $transaction->supplier_id = $request->supplier;
        $transaction->tdate = $request->tdate;
        $transaction->amount = intval($request->amount);
        $transaction->save();

        $temp_product = TempProductModel::where('user_id', Auth::id())->where('voucher', $request->voucher)->get();
        foreach($temp_product as $temp_products)
        {
            $product_transaction = new ProductTransactionModel();
            $product_transaction->voucher = $request->voucher;
            $product_transaction->docnumber = $request->voucher.$randomNum."|".Auth::id();
            $product_transaction->reference = $randomNum;
            $product_transaction->product_id = $temp_products->product_id;
            if($request->voucher == 'PS')
            {
                $product_transaction->PIn = $temp_products->PIn;
                $product_transaction->POut = 0;
                $product_transaction->amount = $temp_products->amount * $temp_products->PIn;
            }
            else
            {
                $product_transaction->POut = $temp_products->POut;
                $product_transaction->PIn = 0;
                $product_transaction->amount = $temp_products->amount * $temp_products->POut;
            }
            
            $product_transaction->piso_discount = $temp_products->piso_discount;
            $product_transaction->save();

            TempProductModel::where('id', $temp_products->id)->delete();
        }

        return redirect($request->link);
    }

    public function deleteTemp()
    {
        // dd(request()->all());
        $id = request()->id;

        TempProductModel::where('id', $id)->delete();
        return redirect(request()->link);
    }

    
}
