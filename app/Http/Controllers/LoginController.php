<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CustomerModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {

            $user = User::where('email', $credentials['email'])->first();
            $customer = CustomerModel::where('email', $credentials['email'])->first();

            // $user->role == '1' ? $request->session()->put('image', '') : $request->session()->put('image', $customer->image);

            $request->session()->regenerate();

            return $user->role == '1' ? redirect()->intended('dashboard') : redirect()->intended('secretary-dashboard');
            
        }
 
        return redirect()->back()->with('status', 'User Not Found!, Please try again');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }

    public function addcustomer(Request $request)
    {
        $customer = new CustomerModel();
        $tdate = Carbon::now()->timezone('Asia/Manila')->format('Y-m-d');

        function generateEmailNumber($firstname, $lastname) {

            $number = mt_rand(100, 999);

            $defaultemail = $firstname.'.'.$lastname.''.$number.''.'@edmark.com';

            if (randomEmailExists($defaultemail)) {
                return generateEmailNumber($firstname, $lastname);
            }

            return $defaultemail;
        }

        function randomEmailExists($email) {
            return User::where('email', $email)->exists();
        }

        if($request->type == 1)
        {
            $email = generateEmailNumber($request->firstname, $request->lastname);
        }
        else
        {
            $email = $request->email;
        }
        

        $customer->firstname = $request->firstname;
        $customer->middlename = $request->middlename;
        $customer->lastname = $request->lastname;
        $customer->contact_number = $request->contact_number;
        $customer->bday = $request->bdate;
        $customer->address = $request->address;
        $customer->encoded_date = $tdate;
        $customer->encoded_by = 1;
        $customer->email = $email;
        $customer->password = Hash::make($request->password);
        $customer->customer_type = $request->type;
        $customer->save();

        $user = new User();

        $user->name = $request->firstname.' '.$request->lastname;
        $user->email = $email;
        $user->password = Hash::make($request->password);
        $user->role = 'customer';
        $user->save();

        // return redirect('customer');
        return redirect()->back()->with('status', 'Customer Add Successfully');
    }
}
