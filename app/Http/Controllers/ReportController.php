<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSetupModel;
use App\Models\ProductsModel;
use App\Models\CustomerModel;
use App\Models\SupplierModel;
use App\Models\TransactionModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function inventory()
    {
       
        // dd($productsetup);  

        return view('admin.inventory');
    }

    public function showinventory()
    {
        $products = "";

        if(Auth::user()->user_type == 1)
        {
            $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tbltransaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->where([['tblproduct_transaction.refund', 0], ['tblproduct_transaction.voucher', '=', 'AI']])->orWhere('tblproduct_transaction.voucher', '=', 'PS')->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id', 'tblproducts.image'])->get();
        }
        else
        {
            $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tbltransaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->where([['tblproduct_transaction.refund', 0], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tbltransaction.status', 1], ['tblproduct_transaction.voucher', '!=', 'AI']])->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id', 'tblproducts.image'])->get();
        }
        
        $product['data'] = $products;

        return json_encode($product);
    }

    public function reportcustomerledger()
    {
        $show = request()->show;
        $customer_id = request()->id;

        if($show == 1)
        {   
            $ledger = [];

            $customer = [];

            if($customer_id == "")
            {
                $customer = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();
            }
            else
            {
                $customer = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->where('tbltransaction.customer_id', $customer_id)->get();
            }

            foreach($customer as $customer1)
            {
                $ledger[$customer1->id] = TransactionModel::select('tbldebt.reference_id', 'tbldebt.id as debt_id', 'tbltransaction.tdate', 'tbldebt.credit', 'tbldebt.debit')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer1->id)->orderBy('tbltransaction.tdate', 'DESC')->get();

                $ledger['balance'][$customer1->id] = TransactionModel::select(DB::raw('FORMAT(sum(tbldebt.credit) - SUM(tbldebt.debit), 2) as totalbalance'))->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer1->id)->get();
            }

            $customers['customer'] = $customer;
            $customers['ledger'] = $ledger;

            return response()->json($customers);
        }
        else if($show == 2)
        {
            $customer = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();

            $customers['customer'] = $customer;

            return response()->json($customers);
        }
    }

    public function export()
    {
        $process = request()->process;

        if($process == 'inventory')
        {
            
            $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tbltransaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->where([['tblproduct_transaction.refund', 0], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tbltransaction.status', 1], ['tblproduct_transaction.voucher', '!=', 'AI']])->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id', 'tblproducts.image'])->get();

            return view('admin.pdf_blade.inventory_blade')->with('products', $products);
        }

        if($process == 'customerpoints')
        {
            
            $customerpoints = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id', DB::raw('sum(tblproduct_transaction.POut * tblproducts.points) as totalpoints'))->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->join('tblproduct_transaction', 'tblproduct_transaction.reference', 'tbltransaction.reference')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tbltransaction.voucher', 'CS')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();

            return view('admin.pdf_blade.customerpoints')->with('customerpoints', $customerpoints);
        }

        if($process == 'grossprofit')
        {
            $from = request()->from;
            $to = request()->to;

            $params = [];
            
            $params['transaction'] = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblproducts.product_code', 'tblproducts.product_name', 'tblproduct_transaction.POut AS qty', 'tblproducts.price as amount', 'tbltransaction.tdate', 'tblproduct_transaction.free')->join('tblproduct_transaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', 'CS')->where('tblproduct_transaction.free', 0)->whereBetween('tbltransaction.tdate', [$from, $to])->orderby('tblcustomer.id')->get();

            $params['totalSum'] = TransactionModel::select('tbltransaction.amount')->where('tbltransaction.voucher', 'CS')->sum('tbltransaction.amount');

            return view('admin.pdf_blade.grossprofit')->with('params', $params);
        }


        if($process == 'allcustomerledger')
        {

            $ledger = [];

            $customer_id = request()->id;

            if($customer_id == "")
            {
                $ledger['customer'] = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();
            }
            else
            {
                $ledger['customer'] = TransactionModel::select('tblcustomer.id', 'tblcustomer.firstname', 'tblcustomer.lastname')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->where('tbltransaction.customer_id', $customer_id)->get();
            }

            foreach($ledger['customer'] as $customer1)
            {
                $ledger[$customer1->id] = TransactionModel::select('tbldebt.reference_id', 'tbldebt.id as debt_id', 'tbltransaction.tdate', 'tbldebt.credit', 'tbldebt.debit')->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer1->id)->orderBy('tbltransaction.tdate', 'DESC')->get();

                $ledger['balance'][$customer1->id] = TransactionModel::select(DB::raw('FORMAT(sum(tbldebt.credit) - SUM(tbldebt.debit), 2) as totalbalance'))->join('tbldebt', 'tbldebt.reference_id', 'tbltransaction.reference')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.customer_id', $customer1->id)->first();
            }

            return view('admin.pdf_blade.allcustomerledger')->with('ledger', $ledger);
        }


        if($process == 'transaction')
        {
            $voucher = request()->voucher;

            $params = [];

            if($voucher == "PS")
            {

                $params['voucher'] = 'Purchase Transaction';

                $params['purchase'] = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
                'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', 'tblsupplier.supplier_name', 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblsupplier', 'tblsupplier.id', 'tbltransaction.supplier_id')->where('tbltransaction.voucher', $voucher)->orderby('tbltransaction.tdate')->get();

                $params['totalSum'] = TransactionModel::select('tbltransaction.amount')->where('tbltransaction.voucher', $voucher)->sum('tbltransaction.amount');
            }
            else if($voucher == "RS")
            {
                $params['voucher'] = 'Exhange Transaction';

                $params['purchase'] = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
                'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', $voucher)->where('tblproduct_transaction.free', 0)->orderby('tbltransaction.tdate')->get();

                $params['totalSum'] = ProductTransactionModel::select(DB::raw('sum(tblproduct_transaction.amount * tblproduct_transaction.POut) as qty'))->where('tblproduct_transaction.voucher', $voucher)->first();
            }
            else
            {
                $params['voucher'] = 'Buy Transaction';

                $params['purchase'] = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
                'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.POut AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', $voucher)->where('tblproduct_transaction.free', 0)->orderby('tbltransaction.tdate')->get();

                $params['totalSum'] = TransactionModel::select('tbltransaction.amount')->where('tbltransaction.voucher', $voucher)->sum('tbltransaction.amount');
            }

            return view('admin.pdf_blade.transaction')->with('params', $params);
        }

    }

    public function createPDF() {
      
      $params1 = [];

      $params1['data'] = CustomerModel::all();

      view()->share('customer',$params1['data']);

      $pdf = PDF::loadView('admin.inventory', $params1);

      return $pdf->download('pdf_file.pdf');
    }

    public function grossprofit()
    {

        $params = [];

        $params['tdate'] = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        return view('admin.grossprofit')->with('params', $params);
    }

    public function showgrossprofit()
    {
        $from = request()->from;
        $to = request()->to;

        $transaction = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblproducts.product_code', 'tblproducts.product_name', 'tblproduct_transaction.POut AS qty', 'tblproducts.price as amount', 'tbltransaction.tdate', 'tblproduct_transaction.free')->join('tblproduct_transaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where([ ['tbltransaction.voucher', 'CS'], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tblproduct_transaction.free', 0] ])->whereBetween('tbltransaction.tdate', [$from, $to])->orderby('tblcustomer.id')->get();

        $transactionData['data'] = $transaction;

        return json_encode($transactionData);
    }

    public function transaction()
    {
        $params = [];

        $params['customer'] = CustomerModel::all();
        $params['supplier'] = SupplierModel::all();

        return view('admin.transaction')->with('params', $params);
    }

    public function showpurchase()
    {
        $voucher = request()->voucher;

        if($voucher == "PS")
        {
            $purchase = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', 'tblsupplier.supplier_name', 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblsupplier', 'tblsupplier.id', 'tbltransaction.supplier_id')->where([ ['tblproduct_transaction.voucher', $voucher], ['tbltransaction.branch_id', Auth::user()->branch_id] ])->orderby('tbltransaction.tdate')->get();
        }
        else if($voucher == "RS")
        {
            $purchase = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where([ ['tbltransaction.voucher', $voucher], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tblproduct_transaction.free', 0] ])->orderby('tbltransaction.tdate')->get();
        }
        else
        {
            $purchase = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.POut AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where([ ['tbltransaction.voucher', $voucher], ['tbltransaction.branch_id', Auth::user()->branch_id], ['tblproduct_transaction.free', 0] ])->orderby('tbltransaction.tdate')->get();
        }
        

        $purchaseData['data'] = $purchase;

        return json_encode($purchaseData);
    }

    public function test()
    {
        return "test";
    }

    public function customerpoints()
    { 

        $show = request()->show;

        if($show)
        {
            $customerpoints = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id', DB::raw('sum(tblproduct_transaction.POut * tblproducts.points) as totalpoints'))->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->join('tblproduct_transaction', 'tblproduct_transaction.reference', 'tbltransaction.reference')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tbltransaction.voucher', 'CS')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();

            $customerpointsdata['data'] = $customerpoints;

            return json_encode($customerpointsdata);

        }

        return view('admin.customerpoints');
    }

    public function customerledger()
    {
       
        // dd($productsetup); 

        $show = request()->show;

        if($show == 1)
        {
            $customerpoints = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id', DB::raw('sum(tblproduct_transaction.POut * tblproducts.points) as totalpoints'))->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->join('tblproduct_transaction', 'tblproduct_transaction.reference', 'tbltransaction.reference')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tbltransaction.voucher', 'CS')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id')->get();

            $customerpointsdata['data'] = $customerpoints;

            return json_encode($customerpointsdata);
        }

        return view('admin.customerledger');
    }

}

