<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotificationsController;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\NotifyController;
use App\Http\Controllers\Api\FavoriteItemController;
use App\Http\Controllers\Api\WinnersController;
use App\Http\Controllers\Api\UserBidController;
use App\Http\Controllers\Api\UserWalletController;
use App\Http\Controllers\Api\UserSettingController;
use App\Http\Controllers\Api\UserProfileSettingController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\AuctionUserEnteredController;
use App\Http\Controllers\Api\AuctionBidUsedController;
use App\Http\Controllers\Api\AuctionStartController;




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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login, Signup, forgotPassword, verifyOTP, ResetPassword.
Route::post('/auth/customer-signup', [AuthController::class, 'register']);
Route::post('/auth/customer-login', [AuthController::class, 'customerLogin']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/verify-otp', [AuthController::class, 'verifyOTP']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'auth:api'], function () {
   
    //Auction
    Route::post('/auction-user', [AuctionUserEnteredController::class, 'auctionUsers']);
    Route::post('/auction-bidding', [AuctionBidUsedController::class, 'auctionBidding']);
    Route::get('/get-market-price/{auctionId}',[AuctionBidUsedController::class, 'getMarketPrice']);
    Route::post('/save-market-price',[AuctionBidUsedController::class, 'saveMarketPrice']);
    Route::post('/user-address',[AuctionBidUsedController::class, 'userAddress']);
    Route::post('/user-shipping-address',[AuctionBidUsedController::class, 'saveShippingData']);

    // Bot user
    Route::post('bot-user',[AuctionBidUsedController::class, 'botUser']);
    Route::post('bot-user-two',[AuctionBidUsedController::class, 'botUserTwo']);

    // Notifications
    Route::get('/notifications', [NotificationsController::class, 'notification']);

    //Bid
    Route::get('/subscription', [BidController::class, 'subscription']);
    Route::get('/non-subscription', [BidController::class, 'nonSubscription']);

    // check Bid of login User
    Route::get('/check-user-bids',[UserBidController::class,'userBid']);

    // Check balance of login user
    Route::get('/check-user-wallet',[UserWalletController::class,'userWallet']);

    //get all Product
    Route::get('/auctions', [ProductController::class, 'auctions']);

    //Notification Alert
    Route::post('/notify-alert', [NotifyController::class, 'notify']);
    Route::post('/de-notify-alert', [NotifyController::class, 'denotify']);

    //Favourite
    Route::post('/add-favourite', [FavoriteItemController::class, 'addFavourite']);
    Route::post('/remove-favourite', [FavoriteItemController::class, 'removeFavourite']);

    // Winners
    Route::get('/winners', [WinnersController::class,'winners']);

    //update customer Profile
    Route::post('/update-profile',[AuthController::class,'updateProfile']);

    //Update User Setting
    Route::post('/update-user-setting',[UserSettingController::class,'updateUserSetting']);

    // Update User Profile Setting
    Route::post('/update-user-profile-setting',[UserProfileSettingController::class,'updateUserProfileSetting']);

    // Profile view
    Route::get('/profile', [UserProfileController::class,'profileView']);
    Route::post('/guest-profile-view',[UserProfileController::class,'guestProfileView']);

});
