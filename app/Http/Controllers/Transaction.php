<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\SupplierModel;
use App\Models\CustomerModel;
use App\Models\ProductsModel;
use App\Models\TempProductModel;
use App\Models\ProductSetupModel;
use App\Models\debtmodel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ApplicationModel;
use App\Events\PusherBroadcast;

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
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.refund', 0)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

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
                $TempProductModel->amount = $request->price;
        }
        else
        {
                $TempProductModel->POut = $request->qty;
                $TempProductModel->PIn = 0;
                $TempProductModel->amount = $productamount->price;
        }
        
        
        $TempProductModel->piso_discount = $request->peso_discount;
        $TempProductModel->user_id = Auth::id();
        $TempProductModel->save();

        $productsetup = ProductSetupModel::where('product_id', $request->product_id)->first();

        // dd($productsetup);

        if($request->voucher == 'CS')
        {
              

            $countqty = intval(floor($request->qty / $productsetup->p_qty));

            // dd($countqty);

            // for($x = 0; $x < $countqty; $x++)
            // { 
            if($countqty > 0)
            {
                $TempProductModel = new TempProductModel();

                $TempProductModel->product_id = $productsetup->free_product_id;
                $TempProductModel->voucher = $request->voucher;
                            
                $TempProductModel->POut = $productsetup->qty * $countqty;
                $TempProductModel->PIn = 0;
                            
                $TempProductModel->amount = $productsetup->amount;
                $TempProductModel->piso_discount = 0;
                $TempProductModel->free = 1;
                $TempProductModel->user_id = Auth::id();
                $TempProductModel->save();
            }
        
        }

        // return redirect($request->link);
        return redirect()->back()->with('status', 'Product Add Successfully');
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
                $product_transaction->amount = $temp_products->amount;
            }
            else
            {
                $product_transaction->POut = $temp_products->POut;
                $product_transaction->PIn = 0;
                $product_transaction->amount = $temp_products->amount;
                $product_transaction->free = $temp_products->free;
            }
            
            $product_transaction->piso_discount = $temp_products->piso_discount;
            $product_transaction->save();

            TempProductModel::where('id', $temp_products->id)->delete();
        }

        if($request->voucher == 'DT')
        {
            $rownum = 1;

            $maxRownum = debtmodel::max('rownum');

            // dd($maxRownum);

            if($maxRownum != "" || $maxRownum != 0)
            {
                $rownum = $maxRownum + 1;
            }

            $debt = new debtmodel();
            $debt->voucher = $request->voucher;
            $debt->reference_id = $randomNum;
            $debt->credit = intval($request->amount);
            $debt->debit = 0;
            $debt->rownum = $rownum;
            $debt->save();
        }

        // return redirect($request->link);
        return redirect()->back()->with('status', 'Transaction Successfully');
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

        

        // ProductTransactionModel::where([ ['product_id', $product_id], ['reference', $reference_id] ])->update(['refund'=> 1]);

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
            $transaction_product->amount = $productsetups->amount;        
            
                
            $transaction_product->piso_discount = 0;
            $transaction_product->free = 1;
            $transaction_product->refund = 1;
            $transaction_product->save();

            // ProductTransactionModel::where([ ['product_id', $productsetups->free_product_id], ['reference', $reference_id] ])->update(['refund'=> 1]);
        }

        // return redirect(request()->link);
        return redirect()->back()->with('status', 'Exchange Successfully');

    }

    public function pendingOrders()
    {
        $params = [];

        $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 0] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->orderby('tblapplication.rownum', 'DESC')->get();

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 0], ['tblapplication.application_id', $application->application_id] ])->get();

        }

        $data['application_id'] = $params;

        return response()->json($data);
    }

    public function pendingapplication()
    {
        $params = [];

        $params['title'] = "Pending";

        $application_id = request()->application_id;
        $status = request()->status;
        $notif = request()->notif;

        if($application_id != "")
        {

            ApplicationModel::where([ ['application_id', $application_id] ])->update(['status' => $status]);

            if($status == 1)
            {
                return redirect()->back()->with('status', 'Approve Successfully')->with('color', 'success');
            }
            else if($status == 2)
            {
                return redirect()->back()->with('status', 'Decline Successfully')->with('color', 'danger');
            }

        }

        if($notif == 1)
        {
            
            $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 0] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->orderby('tblapplication.rownum', 'DESC')->paginate(10);
        }   
        else
        {
            $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 0] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->orderby('tblapplication.rownum', 'DESC')->paginate(10);
        }

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 0], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }

        return view('admin.orders')->with('params', $params);
    }

    public function debttransaction()
    {
        $customer = CustomerModel::all();
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.refund', 0)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

        $params = [];

        $temp_product = TempProductModel::select('tbltempproduct.id', 'tbltempproduct.free', 'tblproducts.product_name', 'tbltempproduct.PIn', 'tbltempproduct.POut', 'tbltempproduct.amount', 'tbltempproduct.piso_discount', DB::raw('tbltempproduct.amount * tbltempproduct.POut - tbltempproduct.piso_discount as total'))->join('tblproducts', 'tblproducts.id', 'tbltempproduct.product_id')->where('user_id', Auth::id())->where('voucher', 'DT')->get();

        $params['customer'] = $customer;
        $params['product'] = $products;
        $params['temp_product'] = $temp_product;
        $params['total'] = $temp_product->sum('total');
        
        return view('admin.debttransaction')->with('params', $params);
    }

    public function paymenttransaction()
    {
        $customer = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->having(DB::raw('sum(tbldebt.credit) - SUM(tbldebt.debit)'), '!=', 0)->get();

        $params = [];

        $customer_id = request()->id;

        $ledger = [];
        $balance = 0;

        if($customer_id != "")
        {
            $ledger = TransactionModel::select('tbldebt.reference_id', 'tbldebt.id as debt_id', 'tbltransaction.tdate', 'tbldebt.credit', 'tbldebt.debit')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer_id)->orderBy('tbltransaction.tdate', 'DESC')->get();

            // dd($ledger);

            $customer_name = CustomerModel::where('id', $customer_id)->first();

            $params['customer_name'] = $customer_name;

            $balance = TransactionModel::select(DB::raw('sum(tbldebt.credit) - SUM(tbldebt.debit) as totalbalance'))->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer_id)->first();
        }

        $params['tdate'] = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        $params['customer'] = $customer;
        $params['ledger'] = $ledger;
        $params['balance'] = $balance;
        
        return view('admin.payment')->with('params', $params);
    }

    public function paydebt(Request $request)
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
        $transaction->customer_id = $request->id;
        $transaction->tdate = $request->tdate;
        $transaction->amount = intval($request->amount);
        $transaction->branch_id = Auth::user()->branch_id;
        $transaction->save();
        // dd(intval($request->totalbalance));

        if(intval($request->totalbalance) == intval($request->amount))
        {
            $active_reference = debtmodel::select('tbldebt.reference_id')->join('tbltransaction', 'tbltransaction.reference', 'tbldebt.reference_id')->where([ ['tbltransaction.customer_id', $request->id], ['tbldebt.active', 1] ])->get();

            // dd($active_reference);

            $params = [];

            foreach($active_reference as $active_references)
            {
                $debt_product = ProductTransactionModel::where('reference', $active_references->reference_id)->get();
                foreach($debt_product as $debt_products)
                {
                    $product_transaction = new ProductTransactionModel();
                    $product_transaction->voucher = $request->voucher;
                    $product_transaction->docnumber = $request->voucher.$randomNum."|".Auth::id();
                    $product_transaction->reference = $randomNum;
                    $product_transaction->product_id = $debt_products->product_id;
                    $product_transaction->PIn = $debt_products->POut;
                    $product_transaction->POut = 0;
                    $product_transaction->amount = $debt_products->amount;
                    
                    
                    $product_transaction->piso_discount = $debt_products->piso_discount;
                    $product_transaction->save();

                    $product_transaction = new ProductTransactionModel();
                    $product_transaction->voucher = $request->voucher;
                    $product_transaction->docnumber = $request->voucher.$randomNum."|".Auth::id();
                    $product_transaction->reference = $randomNum;
                    $product_transaction->product_id = $debt_products->product_id;
                    $product_transaction->POut = $debt_products->POut;
                    $product_transaction->PIn = 0;
                    $product_transaction->amount = $debt_products->amount;
                    
                    
                    $product_transaction->piso_discount = $debt_products->piso_discount;
                    $product_transaction->save();
                }   

                debtmodel::where([ ['reference_id', $active_references->reference_id] ])->update(['active' => 0]);
            }
            // dd($debt_product);
        }

        $rownum = 1;

            $maxRownum = debtmodel::max('rownum');

            // dd($maxRownum);

            if($maxRownum != "" || $maxRownum != 0)
            {
                $rownum = $maxRownum + 1;
            }

            $debt = new debtmodel();
            $debt->voucher = $request->voucher;
            $debt->reference_id = $randomNum;
            $debt->credit = 0;
            $debt->debit = intval($request->amount);
            $debt->rownum = $rownum;
            $debt->active = 0;
            $debt->save();

        // return redirect($request->link);
        return redirect()->back()->with('status', 'Transaction Successfully');
    }

    public function approveapplication()
    {
        $params = [];

        $params['title'] = "Approve";

        $application_id = request()->application_id;
        $status = request()->status;

        if($application_id != "")
        {

            ApplicationModel::where([ ['application_id', $application_id] ])->update(['status' => $status]);

            $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

            $applicationgroupby = ApplicationModel::select('customer_id')->where([ ['application_id', $application_id] ])->groupBy('customer_id')->first();

            $application_sum = ApplicationModel::select(DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->where([ ['application_id', $application_id] ])->first();

            $application = ApplicationModel::where([ ['application_id', $application_id] ])->get();




            $maintransaction = new TransactionModel();

            $maintransaction->voucher = 'CS';
            $maintransaction->docnumber = 'CS'.$application_id."|".Auth::id();
            $maintransaction->reference = $application_id;
            $maintransaction->encoded_by = Auth::id();
            $maintransaction->customer_id = $applicationgroupby->customer_id;
            $maintransaction->tdate = $tdate;
            $maintransaction->amount = intval($application_sum->total);
            $maintransaction->branch_id = Auth::user()->branch_id;
            $maintransaction->save();

            foreach($application as $applications)
            {
                $transaction_product = new ProductTransactionModel();

                $products = ProductsModel::select('price')->where('id', $applications->product_id)->first();

                $transaction_product->voucher = 'CS';
                $transaction_product->docnumber = 'CS'.$application_id."|".Auth::id();
                $transaction_product->reference = $application_id;
                $transaction_product->product_id = $applications->product_id;
                
                $transaction_product->PIn = 0;
                $transaction_product->POut = $applications->qty;
                $transaction_product->amount = $applications->amount;        
                
                    
                $transaction_product->piso_discount = 0;
                $applications->amount < $products->price ? $transaction_product->free = 1 : $transaction_product->free = 0;
                
                $transaction_product->refund = 0;
                $transaction_product->save();
            }

                return redirect()->back()->with('status', 'Completed Successfully')->with('color', 'success');
            

        }

    
        $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 1] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->OrderBy('tblapplication.rownum', 'DESC')->paginate(10);

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 1], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }

        // dd(intval($total));

        return view('admin.orders')->with('params', $params);
    }

    public function cancelledapplication()
    {
        $params = [];

        $params['title'] = "Cancelled";
    
        $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 2] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->OrderBy('tblapplication.rownum', 'DESC')->paginate(10);

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 2], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }

        return view('admin.orders')->with('params', $params);
    }

    public function completeapplication()
    {
        $params = [];

        $params['title'] = "Completed";

    
        $params['application_id'] = ApplicationModel::select('tblapplication.application_id', 'tblapplication.rownum', 'tblapplication.status', 'tblcustomer.firstname', 'tblcustomer.lastname', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->join('tblcustomer', 'tblcustomer.id', 'tblapplication.customer_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 3] ])->groupBy('status', 'customer_id', 'application_id', 'tblcustomer.firstname', 'tblcustomer.lastname', 'tblapplication.rownum')->OrderBy('tblapplication.rownum', 'DESC')->paginate(10);

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['tblapplication.checkout', 1], ['tblapplication.status', 3], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }



        // dd(intval($total));

        return view('admin.orders')->with('params', $params);
    }

    
    
}
