<?php

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

Route::get('products', [ProductController::class, 'index'])->name('products.get');
Route::post('/products', [ProductController::class, 'store'])->name('product.create');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.delete');

Route::get('customers', [CustomerController::class, 'index'])->name('customers.get');
Route::post('/customers', [CustomerController::class, 'store'])->name('customer.create');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.get');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('supplier.create');
Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');
Route::post('suppliers/{supplier}/supply', [SupplierController::class, 'supplyProducts'])->name('supplier.suppliyProducts');

Route::get('employees', [EmployeeController::class, 'index'])->name('employees.get');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employee.create');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');

Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.get');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transaction.create');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transaction.delete');

Route::get('marital-statuses', [MaritalStatusController::class, 'index'])->name('marital-statuses.get');
Route::post('marital-statuses', [MaritalStatusController::class, 'store'])->name('marital-status.create');
Route::delete('marital-statuses/{id}', [MaritalStatusController::class, 'destroy'])->name('marital-status.delete');

Route::get('job-types', [JobTypeController::class, 'index'])->name('job-types.get');
Route::post('job-types', [JobTypeController::class, 'store'])->name('job-type.create');
Route::delete('job-types/{id}', [JobTypeController::class, 'destroy'])->name('job-type.delete');