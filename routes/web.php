<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\KeepController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\RankingController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('verifyOtp', [RegisteredUserController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('validOtp', [RegisteredUserController::class, 'validOtp'])->name('validOtp');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * ==============================
     *        Promotion
     * ==============================
     */
     Route::prefix('promotion')->group(function () {
        Route::get('/promotion', [PromotionController::class, 'promotion'])->name('promotion.promotion');
        Route::get('/getPromotionImage', [PromotionController::class, 'getPromotionImage'])->name('promotion.getPromotionImage');
        Route::get('/promotionDetails/{id}', [PromotionController::class, 'promotionDetails'])->name('promotion.promotionDetails');
    });

    // QR CODE
    Route::get('/qr', [QRController::class, 'qr'])->name('qr');

    /**
     * ==============================
     *        Point
     * ==============================
     */
    Route::prefix('point')->group(function () {
        Route::get('/point', [PointController::class, 'point'])->name('point.point');
        Route::get('/getRedemItem', [PointController::class, 'getRedemItem'])->name('point.getRedemItem');
        Route::get('/view-history', [PointController::class, 'viewHistory'])->name('point.view-history');
        Route::get('/getPointHistory', [PointController::class, 'getPointHistory'])->name('point.getPointHistory');
        Route::get('/getExpiringPoint', [PointController::class, 'getExpiringPoint'])->name('point.getExpiringPoint');
    });

    /**
     * ==============================
     *        Keep
     * ==============================
     */
    Route::get('/keep_listing', [KeepController::class, 'keepListing'])->name('keep_listing');
    Route::get('/keepHistory', [KeepController::class, 'keepHistory'])->name('keepHistory');
    Route::get('/getKeepHistory', [KeepController::class, 'getKeepHistory'])->name('getKeepHistory');
    

    /**
     * ==============================
     *        Order History
     * ==============================
     */
    Route::get('/order_listing', [OrderController::class, 'orderListing'])->name('order_listing');
    Route::get('/getOrderHistory', [OrderController::class, 'getOrderHistory'])->name('getOrderHistory');
    Route::get('/getMerchant', [OrderController::class, 'getMerchant'])->name('getMerchant');
    

    /**
     * ==============================
     *        Profile
     * ==============================
     */
    Route::get('/ranking', [RankingController::class, 'ranking'])->name('ranking');
    Route::get('/getReward', [RankingController::class, 'getReward'])->name('getReward');
    

    /**
     * ==============================
     *        Profile
     * ==============================
     */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/getUserData', [ProfileController::class, 'getUserData'])->name('profile.getUserData');

    Route::get('/profile_image', [ProfileController::class, 'profileImage'])->name('profile.profile_image');
    Route::get('/getProfileImage', [ProfileController::class, 'getProfileImage'])->name('profile.getProfileImage');
    Route::post('/save-image', [ProfileController::class, 'saveimage'])->name('profile.save-image');

    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('profile.update-profile');

    /**
     * ==============================
     *        Verify otp in auth
     * ==============================
     */
    Route::get('/verify-otp', [ProfileController::class, 'verifyOtp'])->name('verify-otp');
    Route::post('/validStoreOtp', [ProfileController::class, 'validStoreOtp'])->name('validStoreOtp');
    
    Route::get('/getPayoutDetails', [GlobalController::class, 'getPayoutDetails'])->name('getPayoutDetails');

    Route::get('/getTotalKeep', [GlobalController::class, 'getTotalKeep'])->name('getTotalKeep');

});

Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');

require __DIR__.'/auth.php';
