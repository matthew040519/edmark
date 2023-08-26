<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSetupModel;
use App\Models\ProductsModel;
use App\Models\CustomerModel;
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

}
