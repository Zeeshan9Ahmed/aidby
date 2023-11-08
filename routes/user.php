<?php

use App\Http\Controllers\Service\BlogController;
use App\Http\Controllers\User\UserController;
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

Route::middleware(['auth', 'is_user', 'is_subscribed'])->group(function () {
    Route::controller(UserController::class)->group(function () { 
        Route::get('/', 'index');

        Route::get('my-profile', 'myProfile');
        Route::get('complete-profile', 'completeProfileForm');
        Route::post('complete-profile', 'completeProfile');

        Route::get('get-categories', 'getCategories');
        Route::get('get-sub-categories/{category_id}', 'getSubCategories');
        Route::post('book-now', 'bookNow');

        Route::get('get-cards', 'getCards');
        Route::post('add-card', 'addCard');
        Route::get('delete-card', 'deleteCard');

        Route::get('category/{sub_category_id}', 'categoryServices');
        Route::get('book-service/{service_id}', 'bookServiceForm');
        Route::post('book-service', 'bookService');

        Route::get('search', 'search');
        Route::get('service-city/{city}', 'serviceCity');

        Route::get('notifications', 'notifications');
        Route::get('update-unread-notifications', 'updateUnreadNotifications');

        Route::get('vital', 'vitalIndex');
        Route::post('vital', 'vitalStore');
        Route::get('vital-data', 'vitalData');

        Route::get('blogs/{my_blog?}', 'blogList');
        Route::post('blog', 'createBlog');
        Route::get('blog/{id}', 'blogDetail');
        Route::post('edit-blog', 'editBlog');
        Route::get('delete-blog/{id}', 'deleteBlog');

        Route::get('chat/{receiver_id?}', 'chatIndex');
        Route::post('read-message', 'readMessage');

        Route::get('save-sos_message', 'saveSoSMessage');
        Route::post('save-contacts', 'saveContacts');
        Route::get('delete-contact', 'deleteContact');

        Route::get('page/{slug}', 'page');

        Route::get('my-booking', 'myBooking');
        Route::post('review', 'createReview');
        Route::get('get-address', 'getAddress');
    });
});