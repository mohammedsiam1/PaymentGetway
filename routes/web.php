<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentCantroller;
use App\Http\Controllers\Payment\FatoorahController;
use App\Http\Controllers\Payment\PaymentCallbackCantroller;

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
    return view('welcome');
});
Route::get('payment/create',[PaymentCantroller::class,'create'])->name('payment.create');
Route::get('payment/callback/success',[PaymentCallbackCantroller::class,'success'])->name('payment.success');
Route::get('payment/callback/cancel',[PaymentCallbackCantroller::class,'cancel'])->name('payment.cancel');




