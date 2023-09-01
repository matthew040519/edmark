<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Models\CustomerModel;
use App\Models\ApplicationModel;
use Illuminate\Support\Facades\Auth;


class CustomerDashboardController extends Controller
{
    public $user_id;
    //

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // $this->user_id = Auth::user()->id;

            $customer = CustomerModel::where('email', Auth::user()->email)->first();

            $this->user_id = $customer->id;

            return $next($request);
        });
    }

    public function index()
    {

        $params = [];

        $params['products'] = ProductsModel::all();

        $params['countPending'] = ApplicationModel::select('application_id')->where([ ['status', 0], ['customer_id', $this->user_id] ])->groupBy('application_id')->count('application_id');

        $params['countApprove'] = ApplicationModel::select('application_id')->where([ ['status', 1], ['customer_id', $this->user_id] ])->groupBy('application_id')->count('application_id');

        $params['countCancel'] = ApplicationModel::select('application_id')->where([ ['status', 2], ['customer_id', $this->user_id] ])->groupBy('application_id')->count('application_id');

        $params['countComplete'] = ApplicationModel::select('application_id')->where([ ['status', 3], ['customer_id', $this->user_id] ])->groupBy('application_id')->count('application_id');

        return view('customer.customerdashboard')->with('params', $params);
    }
}
