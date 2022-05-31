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
use App\Http\Controllers\ManageAuctionController;
use App\Http\Controllers\UserController;


use Illuminate\Http\Request;


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

/*clear cache and config*/
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    dump('Cache Clear!');
    Artisan::call('config:clear');
    dump('Config Clear!');
    Artisan::call('route:clear');
    dump('Route Clear!');
    
    //when upload new project and if 419 page expired issue on server
    //Artisan::call('config:cache');
    //dump('Config Cache Clear!');
    
    Artisan::call('view:clear');
    dump('View Clear!');
    
    //Artisan::call('optimize:clear');
    //Artisan::call('optimize');
    //dump('Optimize');
    return back();
});

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

    //User  List
    Route::get('/user-list',[UserController::class,'userList'])->name('userList');
    Route::get('/user-details/{id}',[UserController::class,'userdetail'])->name('userdetail');

    //Winner List
    Route::get('/winner-list',[UserController::class,'winnerList'])->name('winnerList');

    //Category Routes
    Route::get('/category-list',[CategoryController::class,'categoryList'])->name('categoryList');
    Route::get('/add-category',[CategoryController::class,'addCategory'])->name('addCategory');
    Route::post('/save-category',[CategoryController::class,'saveCategory'])->name('saveCategory');
    Route::get('edit-category/{id}',[CategoryController::class,'editCategory'])->name('editCategory');
    Route::get('/get-category-size/{id}',[CategoryController::class,'getSizes'])->name('getCatSize');
    Route::post('update-Category',[CategoryController::class,'updateCategory'])->name('updateCategory');
    Route::get('delete-category/{id}',[CategoryController::class,'deleteCategory'])->name('deleteCategory');
    Route::post('/change-category-status/{id}',[CategoryController::class,'changeCategoryStatus'])->name('changeCategoryStatus');

    //Size Routes
    Route::get('/size-list',[ProductSizeController::class,'sizeList'])->name('sizeList');
    Route::get('/In-Active-size-list',[ProductSizeController::class,'inActiveSizeList'])->name('inActiveSize');
    Route::get('/add-size',[ProductSizeController::class,'addSize'])->name('addSize');
    Route::post('/save-size',[ProductSizeController::class,'saveSize'])->name('saveSize');
    Route::get('edit-size/{id}',[ProductSizeController::class,'editSize'])->name('editSize');
    Route::post('update-size',[ProductSizeController::class,'updateSize'])->name('updateSize');
    Route::get('delete-size/{id}',[ProductSizeController::class,'deleteSize'])->name('deleteSize');
    Route::post('/change-size-status/{id}',[ProductSizeController::class,'changeSizeStatus'])->name('changeSizeStatus');

    //Product Routes
    Route::get('/add-product',[ProductController::class,'addProduct'])->name('addProduct');
    Route::get('/add-size/{id}',[ProductController::class,'AssignSize'])->name('AssignSize');
    Route::post('/save-product',[ProductController::class,'saveProduct'])->name('saveProduct');
    Route::get('edit-product/{id}',[ProductController::class,'editProduct'])->name('editProduct');
    Route::get('/check-size/{id}/{productId}',[ProductController::class,'editSizes'])->name('checkSize');
    Route::post('update-product',[ProductController::class,'updateProduct'])->name('updateProduct');
    Route::get('delete-product/{id}',[ProductController::class,'deleteProduct'])->name('deleteProduct');
    Route::post('/change-product-status/{id}',[ProductController::class,'changeProductStatus'])->name('changeProductStatus');
    Route::get('preview-product/{id}',[ProductController::class,'previewProduct'])->name('previewProduct');
    Route::get('preview-active-product/{id}',[ProductController::class,'previewActiveProduct'])->name('previewActiveProduct');
    Route::get('preview-complete-product/{id}',[ProductController::class,'previewCompletedProduct'])->name('previewCompletedProduct');


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
    Route::get('/completed-auctions',[ProductController::class,'completedAuctions'])->name('completedAuctions');
    Route::post('/change-auction-status/{id}',[ProductController::class,'changeAuctionStatus'])->name('changeAuctionStatus');
    Route::get('/Bids-Calculation/{id}',[ManageAuctionController::class,'auctionBidsCalculation'])->name('');

    // Logout
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
});

    Route::get('/show-status', function (Request $request) {
        return view('payment');
    })->name('showStatus');

    Route::get('/failed-status', function (Request $request) {
        return view('failed-payment');
    })->name('failedStatus');

    // Route::post('pay-with-paypal',[BidController::class,'payWithPayPal'])->name('paypal');
    Route::get('get-status',[BidController::class,'getPaymentStatus'])->name('getstatus');
    Route::get('paypal-payment',[BidController::class,'ABC']);
    Route::post('paypal-payment',[BidController::class,'ABC'])->name('payment');

    // recharge-wallet
    Route::get('recharge-status',[UserController::class,'rechargePaymentStatus'])->name('rechargeStatus');
    Route::get('recharge-wallet',[UserController::class,'wallet']);
    Route::post('recharge-wallet',[UserController::class,'wallet'])->name('recharge-wallet');

    Route::get('Iframe-products',[ProductController::class,'iFrameAuctions'])->name('iFrameAuctions');
    
// Route::get('pdf',[ProductController::class,'pdf']);
    // Route::get('/auction-index',[ManageAuctionController::class,'index'])->name('auctionIndex');
    // Route::post('/manage-auction',[ManageAuctionController::class,'manageAuction'])->name('manageAuction');