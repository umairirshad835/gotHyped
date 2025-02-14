<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\NotificationController;



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
    return view('login');
});

	Route::get('/login', [HomeController::class, 'index'])->name('login');
    Route::post('/userLogin', [HomeController::class, 'userLogin'])->name('userlogin');


    
Route::group(['middleware' => 'auth'], function () {

    // Dashboard Routes
    Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('dashboard');
    
    // Staff Routes
    Route::get('/staff-list',[StaffController::class,'staffList'])->name('staffList');
    Route::get('/add-staff',[StaffController::class,'addStaff'])->name('addstaff');
    Route::post('/save-staff',[StaffController::class,'saveStaff'])->name('savestaff');
    Route::get('edit-staff/{id}',[StaffController::class,'editStaff'])->name('editstaff');
    Route::post('update-staff',[StaffController::class,'updateStaff'])->name('updatestaff');
    Route::post('/change-staff-status/{id}',[StaffController::class,'changeStaffStatus'])->name('changeStaffStatus');

    //Category Routes
    Route::get('/category-list',[CategoryController::class,'categoryList'])->name('categoryList');
    Route::get('/add-category',[CategoryController::class,'addCategory'])->name('addCategory');
    Route::post('/save-category',[CategoryController::class,'saveCategory'])->name('saveCategory');
    Route::get('edit-category/{id}',[CategoryController::class,'editCategory'])->name('editCategory');
    Route::post('update-Category',[CategoryController::class,'updateCategory'])->name('updateCategory');
    Route::get('delete-category/{id}',[CategoryController::class,'deleteCategory'])->name('deleteCategory');
    Route::post('/change-category-status/{id}',[CategoryController::class,'changeCategoryStatus'])->name('changeCategoryStatus');

    //Size Routes
    Route::get('/size-list',[ProductSizeController::class,'sizeList'])->name('sizeList');
    Route::get('/add-size',[ProductSizeController::class,'addSize'])->name('addSize');
    Route::post('/save-size',[ProductSizeController::class,'saveSize'])->name('saveSize');
    Route::get('edit-size/{id}',[ProductSizeController::class,'editSize'])->name('editSize');
    Route::post('update-size',[ProductSizeController::class,'updateSize'])->name('updateSize');
    Route::get('delete-size/{id}',[ProductSizeController::class,'deleteSize'])->name('deleteSize');
    Route::post('/change-size-status/{id}',[ProductSizeController::class,'changeSizeStatus'])->name('changeSizeStatus');

    //Product Routes
    Route::get('/product-list',[ProductController::class,'productList'])->name('productList');
    Route::get('/add-product',[ProductController::class,'addProduct'])->name('addProduct');
    Route::get('/get-size/{id}',[ProductController::class,'getSizes'])->name('getSize');
    Route::post('/save-product',[ProductController::class,'saveProduct'])->name('saveProduct');
    Route::get('edit-product/{id}',[ProductController::class,'editProduct'])->name('editProduct');
    Route::post('update-product',[ProductController::class,'updateProduct'])->name('updateProduct');
    Route::get('delete-product/{id}',[ProductController::class,'deleteProduct'])->name('deleteProduct');
    Route::get('assign-size/{id}',[ProductController::class,'assignSize'])->name('assignSize');
    Route::post('/save-product-size',[ProductController::class,'saveProductSize'])->name('saveProductSize');
    Route::post('/change-product-status/{id}',[ProductController::class,'changeProductStatus'])->name('changeProductStatus');
    Route::get('preview-product/{id}',[ProductController::class,'previewProduct'])->name('previewProduct');

    //Bid Routes
    Route::get('/bid-list',[BidController::class,'bidList'])->name('bidList');
    Route::get('/add-bid',[BidController::class,'addBid'])->name('addBid');
    Route::post('/save-bid',[BidController::class,'saveBid'])->name('saveBid');
    Route::get('edit-bid/{id}',[BidController::class,'editBid'])->name('editBid');
    Route::post('update-bid',[BidController::class,'updateBid'])->name('updateBid');
    Route::post('/change-bid-status/{id}',[BidController::class,'changeBidStatus'])->name('changeBidStatus');

    //Notifications Routes
    Route::get('/notification-list',[NotificationController::class,'notificationList'])->name('notificationList');
    Route::get('/add-notification',[NotificationController::class,'addNotification'])->name('addNotification');
    Route::post('/save-notification',[NotificationController::class,'saveNotification'])->name('saveNotification');
    Route::get('edit-notification/{id}',[NotificationController::class,'editNotification'])->name('editNotification');
    Route::post('update-notification',[NotificationController::class,'updateNotification'])->name('updateNotification');
    Route::post('/change-notification-status/{id}',[NotificationController::class,'changeNotificationStatus'])->name('changeNotificationStatus');


    // Auctions Management
    Route::get('/pending-auctions',[ProductController::class,'pendingAuctions'])->name('pendingAuctions');
    Route::get('/active-auctions',[ProductController::class,'activeAuctions'])->name('activeAuctions');
    Route::get('/expired-auctions',[ProductController::class,'expiredAuctions'])->name('expiredAuctions');
    Route::post('/change-auction-status/{id}',[ProductController::class,'changeAuctionStatus'])->name('changeAuctionStatus');



    // Logout
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
});


