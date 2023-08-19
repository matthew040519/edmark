<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;

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
    Route::get('/customer',[ProductController::class, 'index']);
    Route::post('/products',[ProductController::class, 'addproduct'])->name('addproduct');
    Route::get('/logout', [LoginController::class, 'logout'] )->name('logout');

});