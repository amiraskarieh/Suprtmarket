<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('products', ProductController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('customers', CustomerController::class);
Route::resource('transactions', TransactionController::class);

Route::get('users/without-polymorphism', [UserController::class, 'getUsersWithoutPolymorphism'])->name('users.withoutPolymorphism');
Route::post('users/add-relation', [UserController::class, 'addRelation'])->name('users.addRelation');

Route::get('/employee/{employeeId}/transactions', [TransactionController::class, 'getEmployeeTransactions'])->name('employee.transactions');

Route::get('/customer/{customerId}/products', [TransactionController::class, 'getCustomerTransactions'])->name('customer.transactions');
Route::get('/transactions', [TransactionController::class, 'getTransactionsBetweenDates'])->name('transactions.between_dates');
Route::get('/products/{product_id}/sales', [ProductController::class, 'getProductSales'])->name('products.sales');
Route::get('/suppliers/{supplier}/supplied-products-count', [SupplierController::class, 'getSuppliedProductsCount'])->name('suppliers.supplied-products-count');
Route::get('logs/recent', [LogController::class, 'getRecentLogs'])->name('logs.recent');
