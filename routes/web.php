<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("order",[OrderController::class,'show'])->name("orders.show")->middleware("throttle:30,1");
Route::get("order/security/{order_id}",[OrderController::class,'security_show'])->name("orders.security")->middleware("throttle:30,1");

Auth::routes([
    'register' => false,
    'reset' => false,
    'forget_password' => false,
]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
