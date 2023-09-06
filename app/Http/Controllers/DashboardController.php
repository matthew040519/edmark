<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\CustomerModel;
use App\Models\ApplicationModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $params = [];

        $branch_id = Auth::user()->branch_id;
        $id = Auth::user()->id;

        $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        $params['sales'] = TransactionModel::select('amount')->where([ ['branch_id', $branch_id],['voucher', 'CS'] ])->sum('amount');

        $params['mysales'] = TransactionModel::select('amount')->where([ ['encoded_by', $id],['voucher', 'CS'] ])->sum('amount');

        $params['todaysales'] = TransactionModel::select('amount')->where([ ['encoded_by', $id],['voucher', 'CS'] , ['tdate', $tdate]])->sum('amount');

        $params['todayorders'] = TransactionModel::select('id')->where([ ['encoded_by', $id],['voucher', 'CS'] ])->count('id');

        $params['countCustomer'] = CustomerModel::select('id')->count('id');

        $params['countPending'] = ApplicationModel::select('application_id')->where('status', 0)->groupBy('application_id')->count('application_id');

        $params['countApprove'] = ApplicationModel::select('application_id')->where('status', 1)->groupBy('application_id')->count('application_id');

        $params['countCancel'] = ApplicationModel::select('application_id')->where('status', 2)->groupBy('application_id')->count('application_id');

        $params['countComplete'] = ApplicationModel::select('application_id')->where('status', 3)->groupBy('application_id')->count('application_id');

        $params['customerpoints'] = $customerpoints = TransactionModel::select('tblcustomer.firstname', 'tblcustomer.image', 'tblcustomer.lastname', 'tblcustomer.id', DB::raw('sum(tblproduct_transaction.POut * tblproducts.points) as totalpoints'))->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->join('tblproduct_transaction', 'tblproduct_transaction.reference', 'tbltransaction.reference')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tbltransaction.voucher', 'CS')->groupBy('tblcustomer.firstname', 'tblcustomer.lastname', 'tblcustomer.id', 'tblcustomer.image')->orderby('totalpoints', 'DESC')->get();

        $params['salesproduct'] = ProductTransactionModel::select('tblproducts.product_name as label', DB::raw('sum(tblproduct_transaction.POut * tblproduct_transaction.amount) as y'))->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.voucher', 'CS')->groupBy('tblproducts.product_name')->get()->toArray();

        $params['salesperday'] = TransactionModel::select('tbltransaction.tdate as label', DB::raw('sum(tblproduct_transaction.POut * tblproduct_transaction.amount) as y'))->join('tblproduct_transaction', 'tblproduct_transaction.docnumber', 'tbltransaction.docnumber')->where('tblproduct_transaction.voucher', 'CS')->groupBy('tbltransaction.tdate')->get()->toArray();

        // dd($params['salesperday']);

        return view('admin.dashboard')->with('params', $params);
    }
}
