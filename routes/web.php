<?php

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
use App\Http\Controllers\SalesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/edit_profile', [HomeController::class, 'edit_profile'])->name('edit_profile');
Route::post('/update_profile/{id}', [HomeController::class, 'update_profile'])->name('update_profile');
Route::get('/password_change', [HomeController::class, 'update_password'])->name('update_password');

Route::resource('category', CategoryController::class);
Route::resource('tax', TaxController::class);
Route::resource('unit', UnitController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('customer', CustomerController::class);
Route::resource('product', ProductController::class);
Route::resource('invoice', InvoiceController::class);
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::resource('purchase', 'PurchaseController');
Route::get('/findPrice', [InvoiceController::class,'findPrice'])->name('findPrice');
// Route::get('/findPricePurchase', 'PurchaseController@findPricePurchase')->name('findPricePurchase');
