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
        $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.refund', 0)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

        $product['data'] = $products;

        return json_encode($product);
    }

    public function export()
    {
        $process = request()->process;

        if($process == 'inventory')
        {
            
            $products = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.refund', 0)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->get();

            return view('admin.pdf_blade.inventory_blade')->with('products', $products);
        }

        if($process == 'grossprofit')
        {
            $from = request()->from;
            $to = request()->to;

            $params = [];
            
            $params['transaction'] = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblproducts.product_code', 'tblproducts.product_name', 'tblproduct_transaction.POut AS qty', 'tblproducts.price as amount', 'tbltransaction.tdate', 'tblproduct_transaction.free')->join('tblproduct_transaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', 'CS')->where('tblproduct_transaction.free', 0)->whereBetween('tbltransaction.tdate', [$from, $to])->orderby('tblcustomer.id')->get();

            $params['totalSum'] = TransactionModel::select('tbltransaction.amount')->join('tblproduct_transaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->where('tbltransaction.voucher', 'CS')->where('tblproduct_transaction.free', 0)->whereBetween('tbltransaction.tdate', [$from, $to])->sum('tbltransaction.amount');

            return view('admin.pdf_blade.grossprofit')->with('params', $params);
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

        $transaction = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.lastname', 'tblproducts.product_code', 'tblproducts.product_name', 'tblproduct_transaction.POut AS qty', 'tblproducts.price as amount', 'tbltransaction.tdate', 'tblproduct_transaction.free')->join('tblproduct_transaction', 'tbltransaction.docnumber', 'tblproduct_transaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tblproduct_transaction.free', 0)->where('tbltransaction.voucher', 'CS')->whereBetween('tbltransaction.tdate', [$from, $to])->orderby('tblcustomer.id')->get();

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
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', 'tblsupplier.supplier_name', 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblsupplier', 'tblsupplier.id', 'tbltransaction.supplier_id')->where('tbltransaction.voucher', $voucher)->orderby('tbltransaction.tdate')->get();
        }
        else if($voucher == "RS")
        {
            $purchase = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.PIn AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', $voucher)->where('tblproduct_transaction.free', 0)->orderby('tbltransaction.tdate')->get();
        }
        else
        {
            $purchase = TransactionModel::select('tblproducts.product_name', 'tblproducts.product_code',
            'tbltransaction.reference', 'tbltransaction.voucher', 'tblproduct_transaction.POut AS qty', DB::raw("CONCAT(tblcustomer.firstname,' ',tblcustomer.lastname) as supplier_name ") , 'tblproduct_transaction.amount', 'tbltransaction.tdate')->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->where('tbltransaction.voucher', $voucher)->where('tblproduct_transaction.free', 0)->orderby('tbltransaction.tdate')->get();
        }
        

        $purchaseData['data'] = $purchase;

        return json_encode($purchaseData);
    }

    public function test()
    {
        return "test";
    }

}

