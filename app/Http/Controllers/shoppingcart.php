<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerModel;
use App\Models\ApplicationModel;
use App\Models\ProductSetupModel;
use Illuminate\Support\Facades\Auth;

class shoppingcart extends Controller
{
    //

    public $user_id;

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

        $total = 0;

        $params['application'] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 0] ])->get();

        foreach($params['application'] as $application)
        {
            $total += $application->qty * $application->price;
        }

        $params['totalSum'] = $total;

        return view('customer.shoppingcart')->with('params', $params);
    }

    public function orderproduct()
    {
        $params = [];

        $search = request()->search;

        if($search == "")
        {
            $params['products'] = ProductsModel::where('active', 1)->paginate(8);
        }
        else
        {
            $params['products'] = ProductsModel::where('active', 1)->Where('product_name', 'like', '%' . $search . '%')->paginate(8);
        }
        

        return view('customer.orderproducts')->with('params', $params);
    }

    public function orderproductdetails()
    {
        $params = [];

        $product_id = request()->id;

        $params['products'] = ProductsModel::select('tblproducts.id', 'tblproducts.image', 'tblproducts.product_details', 'tblproducts.product_name', 'tblproducts.price', DB::raw('sum(tblproduct_transaction.PIn - tblproduct_transaction.POut) as qty'))->join('tblproduct_transaction', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproducts.id', $product_id)->groupBy(['tblproducts.id', 'tblproducts.product_name', 'tblproducts.price', 'tblproducts.id'])->first();

        $params['free_product'] = ProductSetupModel::select('a.product_name as aproduct', 'b.product_name as bproduct', 'tblproductsetup.amount', 'tblproductsetup.qty', 'b.image', 'b.product_details', 'tblproductsetup.id')->join('tblproducts as a', 'a.id', 'tblproductsetup.product_id')->join('tblproducts as b', 'b.id', 'tblproductsetup.free_product_id')->where('tblproductsetup.product_id', $product_id)->get();

        return view('customer.orderproductsdetails')->with('params', $params);
    }

    public function addtocart(Request $request)
    {
        // return $this->user_id;
        $application = new ApplicationModel();

        $application->customer_id = $this->user_id;
        $application->product_id = $request->product_id;
        $application->qty = $request->qty;
        $application->amount = $request->price;
        $application->save();

        $freeproduct = ProductSetupModel::select('a.product_name as aproduct', 'b.product_name as bproduct', 'tblproductsetup.amount', 'tblproductsetup.qty', 'b.image', 'tblproductsetup.free_product_id', 'b.product_details', 'tblproductsetup.id')->join('tblproducts as a', 'a.id', 'tblproductsetup.product_id')->join('tblproducts as b', 'b.id', 'tblproductsetup.free_product_id')->where('tblproductsetup.product_id', $request->product_id)->get();

        foreach($freeproduct as $freeproducts)
        {
            $application = new ApplicationModel();

            $application->customer_id = $this->user_id;
            $application->product_id = $freeproducts->free_product_id;
            $application->qty = $freeproducts->qty * $request->qty;
            $application->amount = $freeproducts->amount;
            $application->save();
        }

        return json_encode(array(
            "statusCode"=>200
        ));

    }

    public function checkout(Request $request)
    {
        $randomNum = 0;

        function generateRandomNumber() {

            $number = mt_rand(1000000000, 9999999999);

            if (randomNumberExists($number)) {
                return generateRandomNumber();
            }

            return $number;
        }

        function randomNumberExists($number) {
            return ApplicationModel::where('application_id', $number)->exists();
        }

        $randomNum = generateRandomNumber();

        ApplicationModel::where([ ['customer_id', $this->user_id], ['checkout', 0] ])->update(['application_id' => $randomNum, 'mop' => $request->mop, 'checkout' => 1, 'pickup_date' => $request->date]);

        return redirect()->back()->with('status', 'Checkout Successfully');
    }

    public function pendingorders()
    {
        $params = [];

        $params['title'] = "Pending";

    
        $params['application_id'] = ApplicationModel::select('application_id', 'status', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 0] ])->groupBy('application_id')->groupBy('status')->get();

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 0], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }



        // dd(intval($total));

        return view('customer.orders')->with('params', $params);
    }

    public function approveorders()
    {
        $params = [];

        $params['title'] = "Approve";
    
        $params['application_id'] = ApplicationModel::select('application_id', 'status', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 1] ])->groupBy('application_id')->groupBy('status')->get();

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 1], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }



        // dd(intval($total));

        return view('customer.orders')->with('params', $params);
    }

    public function cancelledorders()
    {
        $params = [];

        $params['title'] = "Cancelled";
        
        $params['application_id'] = ApplicationModel::select('application_id', 'status', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 2] ])->groupBy('application_id')->groupBy('status')->get();

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 2], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }



        // dd(intval($total));

        return view('customer.orders')->with('params', $params);
    }

    public function completedorders()
    {
        $params = [];

        $params['title'] = "Completed";
    
        $params['application_id'] = ApplicationModel::select('application_id', 'status', DB::raw('sum(tblapplication.qty * tblapplication.amount) as total'))->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 3] ])->groupBy('application_id')->groupBy('status')->get();

        foreach($params['application_id'] as $application)
        {
            $total = 0;

            $params['application'][$application->application_id] = ApplicationModel::select('tblproducts.product_name', 'tblapplication.amount as price', 'tblproducts.product_code', 'tblapplication.id', 'tblapplication.qty', 'tblproducts.image')->join('tblproducts', 'tblproducts.id', 'tblapplication.product_id')->where([ ['customer_id', $this->user_id], ['tblapplication.checkout', 1], ['tblapplication.status', 3], ['tblapplication.application_id', $application->application_id] ])->get();

          
        }



        // dd(intval($total));

        return view('customer.orders')->with('params', $params);
    }
}
