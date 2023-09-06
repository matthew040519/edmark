<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CustomerModel;
use App\Models\ProductTransactionModel;
use Illuminate\Support\Facades\DB;

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

            // dd($credentials['email']);

            $user = User::where('email', $credentials['email'])->first();
            $customer = CustomerModel::where('email', $credentials['email'])->first();

            $user->role == 'admin' ? $request->session()->put('image', '') : $request->session()->put('image', $customer->image);

            $request->session()->regenerate();

            return $user->role == 'admin' ? redirect()->intended('dashboard') : redirect()->intended('customerdashboard');

            // if($user->role == 'admin')
 
            
        }
 
        return redirect()->back()->with('status', 'User Not Found!, Please try again');
        // return "not found";
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }

    public function test()
    {
        $salesproduct = ProductTransactionModel::select('tblproducts.product_name as label', DB::raw('sum(tblproduct_transaction.POut * tblproduct_transaction.amount) as y'))->join('tblproducts', 'tblproducts.id', 'tblproduct_transaction.product_id')->where('tblproduct_transaction.voucher', 'CS')->groupBy('tblproducts.product_name')->get();

        // dd($salesproduct->toArray());

        // $dataPoints = array(
        //             array("label"=> "Education", "y"=> 284935),
        //             array("label"=> "Entertainment", "y"=> 256548),
        //             array("label"=> "Lifestyle", "y"=> 245214),
        //             array("label"=> "Business", "y"=> 233464),
        //             array("label"=> "Music & Audio", "y"=> 200285),
        //             array("label"=> "Personalization", "y"=> 194422),
        //             array("label"=> "Tools", "y"=> 180337),
        //             array("label"=> "Books & Reference", "y"=> 172340),
        //             array("label"=> "Travel & Local", "y"=> 118187),
        //             array("label"=> "Puzzle", "y"=> 107530)
        //         );

        return view('welcome')->with('dataPoints', $salesproduct->toArray());
    }

}
