<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Service\SubscriptionController;

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

Route::controller(AuthController::class)->group(function () { 

    Route::get('/', 'loginForm')->name('login');

    Route::prefix('auth')->group(function () {
        Route::get('pre-sign-up', 'preSignUpForm');

        Route::post('login/{provider}/callback', 'socialLogin'); // Social Login

        Route::get('login', 'loginForm')->name('login');
        Route::post('login', 'login');

        Route::get('sign-up/{type}', 'signUpForm');
        Route::post('sign-up/{type}', 'signUp');


        Route::get('verify', 'verifyForm');
        Route::post('verify', 'verify');

        Route::get('logout', 'logout');
    });
});

Route::controller(SubscriptionController::class)->group(function () { 
    Route::middleware(['auth'])->group(function () { // is_subscription_purchased
        Route::get('subscription', 'subscription')->name('subscription');
        Route::get('pay-now', 'payNowForm');

        Route::get('get-cards', 'getCards');
        Route::post('add-card', 'addCard');
        
        Route::get('delete-card', 'deleteCard');
        Route::get('set-as-default', 'setAsDefaultCard');
        Route::post('pay-now', 'payNow');
    });
});

//Admin Panel
Route::get('/admin/login',[IndexController::class,'login'])->name('admin.login');
Route::post('/admin/login',[IndexController::class,'login_process'])->name('login-process');  