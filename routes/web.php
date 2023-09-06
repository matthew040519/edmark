<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\shoppingcart;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CustomerDashboardController;

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
    return view('home');
});

Route::get('/landing-products', function () {
    return view('products');
});
Route::get('/landing-products', [LandingController::class, 'products'] );

Route::get('/login', function () {
    return view('authentication.login');
})->name('login');

Route::post('/login-user', [LoginController::class, 'authenticate'] )->name('loginuser');
Route::get('/logout', [LoginController::class, 'logout'] )->name('logout');



Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::middleware(['restrictRole:admin'])->group(function() {

        Route::get('/dashboard',[DashboardController::class, 'index']);
        Route::get('/branch',[BranchController::class, 'index']);
        Route::get('/products',[ProductController::class, 'index']);
        Route::get('/products-setup',[ProductController::class, 'productsetup']);
        Route::post('/products-setup',[ProductController::class, 'addproductsetup'])->name('addproductsetup');
        Route::post('/products',[ProductController::class, 'addproduct'])->name('addproduct');
        Route::post('/updateproducts',[ProductController::class, 'updateproducts'])->name('updateproducts');
        Route::get('/customer',[CustomerController::class, 'index']);
        Route::get('/customer/pdf',[CustomerController::class, 'createPDF']);
        Route::post('/customer',[CustomerController::class, 'addcustomer'])->name('addcustomer');
        Route::get('/supplier',[SupplierController::class, 'index']);
        Route::post('/supplier',[SupplierController::class, 'addsupplier'])->name('addsupplier');
        Route::post('/updatesupplier',[SupplierController::class, 'updatesupplier'])->name('updatesupplier');
        Route::get('/purchase-products',[Transaction::class, 'PurchaseProducts']);
        Route::get('/delete-temp',[Transaction::class, 'deleteTemp']);
        Route::get('/buy-products',[Transaction::class, 'BuyProducts']);
        Route::get('/refund-products',[Transaction::class, 'RefundProducts']);
        Route::get('/getReference',[Transaction::class, 'getReference']);
        Route::get('/getProductTransaction',[Transaction::class, 'getProductTransactions']);
        Route::get('/refund',[Transaction::class, 'refundtransaction']);
        
        Route::get('/pending-application',[Transaction::class, 'pendingapplication']);
        Route::get('/approve-application',[Transaction::class, 'approveapplication']);
        Route::get('/cancel-application',[Transaction::class, 'cancelledapplication']);
        Route::get('/completed-application',[Transaction::class, 'completeapplication']);
        
        Route::post('/purchase-products',[Transaction::class, 'insertTemp'])->name('addtempproduct');
        Route::post('/add-purchase-products',[Transaction::class, 'insert_purchases'])->name('addpurchases');
        

        Route::get('/inventory',[ReportController::class, 'inventory']);
        Route::get('/transaction',[ReportController::class, 'transaction']);
        Route::get('/showtransaction',[ReportController::class, 'showpurchase']);
        Route::get('/showinventory',[ReportController::class, 'showinventory']);
        Route::get('/gross-profit',[ReportController::class, 'grossprofit']);
        Route::get('/show-gross-profit',[ReportController::class, 'showgrossprofit']);
        Route::get('/customer-points',[ReportController::class, 'customerpoints']);
        Route::get('/export',[ReportController::class, 'export']);

    });


    Route::middleware(['restrictRole:customer'])->group(function() {

        Route::get('/customerdashboard',[CustomerDashboardController::class, 'index']);
        Route::get('/shopping-cart',[shoppingcart::class, 'index']);
        Route::get('/order-product',[shoppingcart::class, 'orderproduct'])->name('searchproducts');
        Route::get('/order-product-details',[shoppingcart::class, 'orderproductdetails']);
        Route::post('/add-to-cart',[shoppingcart::class, 'addtocart']);
        Route::post('/checkout',[shoppingcart::class, 'checkout'])->name('checkout');

        Route::get('/pending-orders',[shoppingcart::class, 'pendingorders']);
        Route::get('/approve-orders',[shoppingcart::class, 'approveorders']);
        Route::get('/cancelled-orders',[shoppingcart::class, 'cancelledorders']);
        Route::get('/completed-orders',[shoppingcart::class, 'completedorders']);

        Route::get('/settings',[CustomerDashboardController::class, 'settings']);

        Route::post('/updatesettings',[CustomerDashboardController::class, 'updatesettings'])->name('updatesettings');

    });

});