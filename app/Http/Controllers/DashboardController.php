<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $params = [];

        $branch_id = Auth::user()->branch_id;
        $id = Auth::user()->id;

        $params['sales'] = TransactionModel::select('amount')->where([ ['branch_id', $branch_id],['voucher', 'CS'] ])->sum('amount');

        $params['mysales'] = TransactionModel::select('amount')->where([ ['encoded_by', $id],['voucher', 'CS'] ])->sum('amount');

        $params['countCustomer'] = CustomerModel::select('id')->count('id');

        // dd($sales);

        return view('admin.dashboard')->with('params', $params);
    }
}
