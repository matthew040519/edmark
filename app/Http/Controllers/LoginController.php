<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}
