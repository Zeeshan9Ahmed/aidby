<?php

// use App\Http\Controllers\Service\BlogController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware'=>'admins'],function(){

    Route::controller(IndexController::class)->group(function () { 
        Route::get('/dashboard', 'dashboard')->name('admin.dashboard');

        Route::get('/logout','logout')->name('admin.logout');

    });

    Route::get('users',[UserController::class,'users'])->name('admin.users');
    Route::post('/delete-users',[UserController::class,'delete_users'])->name('admin.delete-users');

    Route::get('service-provider',[UserController::class,'service_provider'])->name('admin.service-provider');

    //Content
    Route::get('/contents',[UserController::class,'contents'])->name('contents');
    Route::get('/edit-content/{id}',[UserController::class,'edit_content'])->name('edit-content');
    Route::post('/update-content',[UserController::class,'update_content'])->name('update-content');
    
    //Categories
    Route::get('/categories',[CoreController::class,'categories'])->name('admin.categories');
    Route::get('/create_category',[CoreController::class,'create_category'])->name('admin.create_category');
    Route::post('/store_category',[CoreController::class,'store_category'])->name('admin.store_category');
    Route::get('/edit_category/{id}',[CoreController::class,'edit_category'])->name('admin.edit_category');
    Route::post('/update_category',[CoreController::class,'update_category'])->name('admin.update_category');
    Route::post('/delete_category',[CoreController::class,'delete_category'])->name('admin.delete_category');
    Route::get('delete-category-image/{id}',[CoreController::class,'delete_category_image'])->name('admin.delete_category_image');

});