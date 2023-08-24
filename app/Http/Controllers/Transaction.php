<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\SupplierModel;
use App\Models\CustomerModel;
use App\Models\ProductsModel;
use App\Models\TempProductModel;
use App\Models\ProductSetupModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

        $params = [];

        $temp_product = TempProductModel::select('tbltempproduct.id', 'tbltempproduct.free', 'tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.POut', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.POut - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where('voucher', 'CS')->get();

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

        $productsetup = ProductSetupModel::where('product_id', $request->product_id)->get();

        // dd($productsetup);

        if($request->voucher == 'CS')
        {
            foreach($productsetup as $productsetups)
            {
                $TempProductModel = new TempProductModel();

                $TempProductModel->product_id = $productsetups->free_product_id;
                $TempProductModel->voucher = $request->voucher;
                
                $TempProductModel->POut = $productsetups->qty;
                $TempProductModel->PIn = 0;
                
                $TempProductModel->amount = $productsetups->amount;
                $TempProductModel->piso_discount = 0;
                $TempProductModel->free = 1;
                $TempProductModel->user_id = Auth::id();
                $TempProductModel->save();
            }
        }

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
        if($request->voucher == 'PS')
        {
            $transaction->supplier_id = $request->supplier;
        }
        else
        {
            $transaction->customer_id = $request->supplier;
        }
        $transaction->tdate = $request->tdate;
        $transaction->amount = intval($request->amount);
        $transaction->branch_id = Auth::user()->branch_id;
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
                $product_transaction->free = $temp_products->free;
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

    public function RefundProducts()
    {
        $customer = CustomerModel::all();
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

        $params = [];

        $reference = request()->reference;

        if($reference == ""){

            $temp_product = [];
            $params['total'] = 0;
        }
        else
        {
            $temp_product = TempProductModel::select('tbltempproduct.id', 'tbltempproduct.free', 'tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.POut', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.POut - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where([ ['voucher', 'CS'], ['reference', $reference] ])->get();
            
            $params['total'] = $temp_product->sum('total');
        }

        

        $params['customer'] = $customer;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        
        
        return view('admin.exchangeproducts')->with('params', $params);
    }

    public function getReference()
    {
        $customer_id = request()->customer_id;

        $transaction = TransactionModel::select('reference')->where([['customer_id', $customer_id], ['voucher', 'CS']])->get();

        $reference['data'] = $transaction;

        return json_encode($reference);
    }


    public function getProductTransactions()
    {
        $reference_id = request()->reference_id;

        $transaction = ProductTransactionModel::select('tblproduct_transaction.id', 'tblproduct_transaction.refund', 'tblproduct_transaction.product_id', 'tblproduct_transaction.reference', 'tblproduct_transaction.free', 'tblproducts.product_name', 'tblproduct_transaction.PIn', 'tblproduct_transaction.POut', 'tblproduct_transaction.amount', 'tblproduct_transaction.piso_discount', DB::raw('tblproduct_transaction.amount * tblproduct_transaction.POut - tblproduct_transaction.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('reference', $reference_id)->get();

        $transactionData['data'] = $transaction;

        return json_encode($transactionData);
    }

    public function refundtransaction()
    {
        $id = request()->id;
        $reference_id = request()->reference_id;
        $product_id = request()->product_id;

        $transaction = TransactionModel::where('reference', $reference_id)->first();

        $product_transaction = ProductTransactionModel::where([ ['product_id', $product_id], ['reference', $reference_id] ])->first();

        // dd($reference_id);

        $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

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

        $maintransaction = new TransactionModel();

        $maintransaction->voucher = 'RS';
        $maintransaction->docnumber = 'RS'.$randomNum."|".Auth::id();
        $maintransaction->reference = $randomNum;
        $maintransaction->encoded_by = Auth::id();
        $maintransaction->customer_id = $transaction->customer_id;
        $maintransaction->tdate = $tdate;
        $maintransaction->amount = intval(-$product_transaction->amount);
        $maintransaction->branch_id = Auth::user()->branch_id;
        $maintransaction->save();

        

        ProductTransactionModel::where([ ['product_id', $product_id], ['reference', $reference_id] ])->update(['refund'=> 1]);

        $transaction_product = new ProductTransactionModel();

        $transaction_product->voucher = 'RS';
        $transaction_product->docnumber = 'RS'.$randomNum."|".Auth::id();
        $transaction_product->reference = $randomNum;
        $transaction_product->product_id = $product_transaction->product_id;
        
        $transaction_product->PIn = $product_transaction->POut;
        $transaction_product->POut = 0;
        $transaction_product->amount = $product_transaction->amount * $product_transaction->POut;        
        
            
        $transaction_product->piso_discount = $product_transaction->piso_discount;
        $transaction_product->refund = 1;
        $transaction_product->save();

        $productsetup = ProductSetupModel::where('product_id', $product_id)->get();
        
        foreach($productsetup as $productsetups)
        {
            $transaction_product = new ProductTransactionModel();

            $transaction_product->voucher = 'RS';
            $transaction_product->docnumber = 'RS'.$randomNum."|".Auth::id();
            $transaction_product->reference = $randomNum;
            $transaction_product->product_id = $productsetups->free_product_id;
            
            $transaction_product->PIn = $productsetups->qty;
            $transaction_product->POut = 0;
            $transaction_product->amount = $productsetups->amount * $productsetups->qty;        
            
                
            $transaction_product->piso_discount = 0;
            $transaction_product->free = 1;
            $transaction_product->refund = 1;
            $transaction_product->save();

            ProductTransactionModel::where([ ['product_id', $productsetups->free_product_id], ['reference', $reference_id] ])->update(['refund'=> 1]);
        }

        return redirect(request()->link);

    }
    
}
