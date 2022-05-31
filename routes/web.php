<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [CustomerController::class , 'index'])->name('home');
Route::get('datatable', [CustomerController::class , 'datatables'])->name('alldata');
Route::post('customerimport', [CustomerController::class , 'importCustomer'])->name('customerimport');
Route::get('totalcustomer', [CustomerController::class , 'totalCustomer'])->name('totalcustomer');
Route::get('totalmalecustomer', [CustomerController::class , 'totalMaleCustomer'])->name('totalmalecustomer');
Route::get('totalfemalecustomer', [CustomerController::class , 'totalFemaleCustomer'])->name('totalfemalecustomer');


