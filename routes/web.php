<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\SettingsController;
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

Route::get("settings", [SettingsController::class, 'index'])->name("settings.index");
Route::post("settings", [SettingsController::class, 'update'])->name("settings.update");


Auth::routes([
    'register' => false,
    'reset' => false,
    'forget_password' => false,
]);


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get("/accounts", [AccountController::class, 'index'])->name("accounts.index");
});


Route::get("/artisan/migrate", function () {
    Artisan::call('migrate');
    return "Done";
})->middleware("auth");

Route::get("/artisan/schedule/run", function () {
    Artisan::call('schedule:run');
    return Artisan::output();
});

Route::get("test", function () {
    $mpdf = new Mpdf(['autoLangToFont' => true]);

    $mpdf->WriteHTML('<div >
    <span lang="zh">세계를 </span>
    <span lang="ko">에 대하여</span>,
    <span lang="ko"> 너와 나, </span>
    <span lang="ar">العربية</span>
</div>');

    $mpdf->Output();
});
