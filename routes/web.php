<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminComplainController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mpdf\Mpdf;

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


Route::get('captcha-refresh', [CaptchaController::class, 'refresh'])->name('captcha.refresh');

Route::get('/', [OrdersController::class, 'welcome'])->name("welcome");

Route::get("/order/check/has/security", [OrdersController::class, 'check_if_order_has_security'])->name("order.check.has.security")->middleware("throttle:30,1");
Route::get("order/{order_id}", [OrdersController::class, 'show'])->name("orders.show")->middleware("throttle:30,1");
Route::get("order/security/{order_id}", [OrdersController::class, 'show_security'])->name("orders.security")->middleware("throttle:30,1");
Route::get("order/security/validate/{order_id}", [OrdersController::class, 'validate_security'])->name("orders.security.validate")->middleware("throttle:30,1");
Route::post("complain/{order}/store", [ComplainController::class, 'store'])->name("client.complain.store");

Auth::routes([
    'register' => false,
    'reset' => true,
    'forget_password' => false,
]);


Route::get("/artisan/{command}", function ($command) {
    Artisan::call($command);
    dd(Artisan::output());
})->middleware("auth");

Route::get("/shell_exec/{command}", function ($command) {
    dd(shell_exec($command));
})->middleware("auth");

Route::get("/artisan/schedule/run", function () {
    Artisan::call('schedule:run');
    return Artisan::output();
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/coupons', [CouponsController::class, 'index'])->name('coupons.index');
    Route::get("/accounts", [AccountController::class, 'index'])->name("accounts.index");
    Route::get("settings", [SettingsController::class, 'index'])->name("settings.index");
    Route::post("settings", [SettingsController::class, 'update'])->name("settings.update");
    Route::get("complains", [AdminComplainController::class, 'index'])->name("complains.index");
    Route::resource("users", UserController::class);
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});
