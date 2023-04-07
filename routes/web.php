<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\CompanyController;

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

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::resource('/company',CompanyController::class);
    Route::get('/companyData',[CompanyController::class,'ssd']);
    Route::resource('/employee',EmployeeController::class);
    Route::get('/employeeData',[EmployeeController::class,'ssd']);
});

