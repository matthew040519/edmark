<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $params = [];

        $branch_id = Auth::user()->branch_id;
        $id = Auth::user()->id;

        $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        $params['sales'] = TransactionModel::select('amount')->where([ ['branch_id', $branch_id],['voucher', 'CS'] ])->orwhere('voucher', 'RS')->sum('amount');

        $params['mysales'] = TransactionModel::select('amount')->where([ ['encoded_by', $id],['voucher', 'CS'] ])->orwhere('voucher', 'RS')->sum('amount');

        $params['todaysales'] = TransactionModel::select('amount')->where([ ['encoded_by', $id],['voucher', 'CS'] , ['tdate', $tdate]])->orwhere('voucher', 'RS')->sum('amount');

        $params['todayorders'] = TransactionModel::select('id')->where([ ['encoded_by', $id],['voucher', 'CS'] ])->count('id');

        $params['countCustomer'] = CustomerModel::select('id')->count('id');

        // dd($sales);

        return view('admin.dashboard')->with('params', $params);
    }
}
