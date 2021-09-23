<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SalaryController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

     'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me',[AuthController::class, 'me']);
    Route::post('register',[AuthController::class, 'register']);

});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
///Employee Routes
Route::post('create-employee',[EmployeeController::class, 'create'])->name('create-employee');
Route::get('employees',[EmployeeController::class, 'index'])->name('employees');
Route::delete('delete-employee/{id}',[EmployeeController::class, 'delete'])->name('delete-employee');
Route::put('edit-employee/{id}',[EmployeeController::class, 'edit'])->name('edit-employee');
Route::post('update-employee',[EmployeeController::class, 'update'])->name('update-employee');
Route::resource('supplier', SupplierController::class);
Route::resource('category', CategoryController::class);
Route::resource('customer', CustomerController::class);
Route::resource('product', ProductController::class);
Route::resource('expense', ExpenseController::class);
Route::resource('salary', SalaryController::class);

Route::post('stockupdate/{id}',[ProductController::class, 'stockupdate'])->name('stockupdate');
//end
