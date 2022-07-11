<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\FatoorahController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('payment',[FatoorahController::class,'create'])->name('payment');

Route::get('payment/success',[FatoorahController::class,'success'])->name('success');
Route::get('payment/cancel',[FatoorahController::class,'cancel'])->name('cancel');