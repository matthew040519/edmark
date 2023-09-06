<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsModel;
use App\Models\CustomerModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionModel;
use App\Models\ApplicationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CustomerDashboardController extends Controller
{
    public $user_id;
    //

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

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

        $params['points'] = TransactionModel::select(DB::raw('sum(tblproduct_transaction.POut * tblproducts.points) as totalpoints'))->join('tblcustomer', 'tblcustomer.id', 'tbltransaction.customer_id')->join('tblproduct_transaction', 'tblproduct_transaction.reference', 'tbltransaction.reference')->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tbltransaction.voucher', 'CS')->where('tbltransaction.customer_id', $this->user_id)->first();

        return view('customer.customerdashboard')->with('params', $params);
    }

    public function settings()
    {
        $params = [];

        $user = CustomerModel::where('id', $this->user_id)->first();

        return view('customer.settings')->with('user', $user);
    }

    public function updatesettings(Request $request)
    {
        $firstname = $request->firstname;
        $file = $request->file('image');
        $middlename = $request->middlename;
        $lastname = $request->lastname;
        $email = $request->email;
        $contact_number = $request->contact_number;
        $bday = $request->bday;
        $password = $request->password;
        $address = $request->address;
        $id = $request->id;

        // dd($request->password);

        CustomerModel::where('id', $id)->update(['firstname' => $firstname, 'middlename' => $middlename, 'lastname' => $lastname, 'contact_number' => $contact_number, 'bday' => $bday, 'address' => $address]);

        if($file)
        {
            CustomerModel::where('id', $id)->update(['image' => $file->getClientOriginalName()]);
            $destinationPath = 'profile_picture';
            $file->move($destinationPath,$file->getClientOriginalName());
        }
        if($password != "")
        {
            CustomerModel::where('id', $id)->update(['password' => Hash::make($password)]);
            User::where('email', $email)->update(['password' => Hash::make($password)]);
        }

        return redirect()->back()->with('status', 'Update Successfully');
    }

}
