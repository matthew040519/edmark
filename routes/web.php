<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Transaction;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('authentication.login');
})->name('login');

Route::post('/login-user', [LoginController::class, 'authenticate'] )->name('loginuser');



Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::get('/dashboard',[DashboardController::class, 'index']);
    Route::get('/branch',[BranchController::class, 'index']);
    Route::get('/products',[ProductController::class, 'index']);
    Route::post('/products',[ProductController::class, 'addproduct'])->name('addproduct');
    Route::get('/customer',[CustomerController::class, 'index']);
    Route::post('/customer',[CustomerController::class, 'addcustomer'])->name('addcustomer');
    Route::get('/supplier',[SupplierController::class, 'index']);
    Route::post('/supplier',[SupplierController::class, 'addsupplier'])->name('addsupplier');
    Route::get('/purchase-products',[Transaction::class, 'PurchaseProducts']);
    Route::post('/purchase-products',[Transaction::class, 'insertTemp'])->name('addtempproduct');
    Route::post('/add-purchase-products',[Transaction::class, 'insert_purchases'])->name('addpurchases');
    Route::get('/logout', [LoginController::class, 'logout'] )->name('logout');

});