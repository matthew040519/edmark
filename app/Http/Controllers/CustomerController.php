<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    //

    public function index()
    {
        $customer = CustomerModel::all();

        return view('admin.customer')->with('customer', $customer);
    }

    public function addcustomer(Request $request)
    {
        $customer = new CustomerModel();
        $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        $customer->firstname = $request->firstname;
        $customer->middlename = $request->middlename;
        $customer->lastname = $request->lastname;
        $customer->contact_number = $request->contact_number;
        $customer->bday = $request->bdate;
        $customer->address = $request->address;
        $customer->encoded_date = $tdate;
        $customer->encoded_by = Auth::id();
        $customer->email = $request->firstname.'.'.$request->lastname.'@edmark.com';
        $customer->password = Hash::make('12345');
        $customer->save();

        $user = new User();

        $user->name = $request->firstname.' '.$request->lastname;
        $user->email = $request->firstname.'.'.$request->lastname.'@edmark.com';
        $user->password = Hash::make('12345');
        $user->role = 'customer';
        $user->save();

        // return redirect('customer');
        return redirect()->back()->with('status', 'Customer Add Successfully');
    }

    public function createPDF() {
      
      $params1 = [];

      $params1['data'] = CustomerModel::all();

      view()->share('customer',$params1['data']);

      $pdf = PDF::loadView('admin.inventory', $params1);

      return $pdf->download('pdf_file.pdf');
    }

    public function test()
    {
        return "test";
    }
}
