<?php

use App\Http\Controllers\Service\BlogController;
use App\Http\Controllers\Service\BookingController;
use App\Http\Controllers\Service\ChatController;
use App\Http\Controllers\Service\ProfileController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\SubscriptionController;
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

Route::middleware(['is_service_provider'])->group(function () {


    Route::get('get-cards', [SubscriptionController::class, 'getCards']);
    Route::post('add-card', [SubscriptionController::class, 'addCard']);
    Route::get('delete-card', [SubscriptionController::class, 'deleteCard']);


    Route::middleware(['is_subscribed'])->group(function () {

    Route::get('/', [ServiceController::class, 'index']);

    Route::get('/notifications', [ServiceController::class, 'notifications']);
    Route::get('/update-unread-notifications', [ServiceController::class, 'updateUnreadNotifications']);
    Route::get('/save-sos_message', [ServiceController::class, 'saveSoSMessage']);
    
    
    Route::post('/review', [ServiceController::class, 'createReview']);
    Route::get('/get-sub-categories/{category_id}', [ServiceController::class, 'getSubCategories']);

    Route::get('page/{page}', [UserController::class, 'page']);
    
    Route::post('service', [ServiceController::class,'addService']);
    Route::get('delete-services', [ServiceController::class,'deleteServices']);
    Route::get('/requests', [ServiceController::class, 'serviceRequestForm']);
    Route::get('/service-request-status', [ServiceController::class, 'serviceRequestStatus']);
    Route::get('/service-detail/{type}/{id}', [ServiceController::class, 'serviceDetail']);
    Route::get('/mark-complete-service', [ServiceController::class, 'markCompleteService']);
    // Route::get('/service/{type}', [ServiceController::class, 'serviceDetail']);
    
    
    Route::get('complete-profile', [ServiceController::class,'completeProfileForm']);
    Route::post('complete-profile', [ServiceController::class, 'completeProfile']);
    Route::get('/logout', [ServiceController::class, 'logout']);
    
    

    Route::get('my-profile', [ProfileController::class, 'getProfile']);
    Route::get('delete-contact', [ProfileController::class, 'deleteContact']);
    Route::post('save-contacts', [ProfileController::class, 'saveContacts']);
    // save-contacts
    Route::get('chat-list', [ChatController::class,'chatList']);
    Route::post('read-message', [ChatController::class,'readMessage']);


    Route::get('bookings', [BookingController::class,'bookingIndex']);

    Route::get('subscription', [SubscriptionController::class,'index']);

    


    Route::get('blogs', [BlogController::class,'index']);
    Route::post('blog', [BlogController::class,'createBlog']);
    Route::post('edit-blog', [BlogController::class,'editBlog']);
    Route::get('delete-blog/{id}', [BlogController::class,'deleteBlog']);
    Route::get('blog/{id}', [BlogController::class,'blogDetail']);
    Route::get('my-blogs', [BlogController::class,'myBlogs']);
});
    
});