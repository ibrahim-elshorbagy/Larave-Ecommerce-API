<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductIndexingController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['guest','api'])->group(function () {

//------------------------------ Login system -----------------------------------------//

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

Route::post('/reset-password', [NewPasswordController::class, 'store']);

    // Cart routes For Not User
    Route::prefix('guest/cart')->group(function() {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add/{product:slug}', [CartController::class, 'add']);
        Route::post('/remove/{product:slug}', [CartController::class, 'remove']);
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity']);
    });

});
//----------------------------------------------------------------------------------//

Route::middleware(['auth:sanctum','role:user'])->group(function () {

//----------------------------------------------------------------------------------//

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

// Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//                 ->middleware(['signed', 'throttle:6,1']);

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                 ->middleware(['throttle:6,1']);

    // Cart routes For Auth User
    Route::prefix('cart')->group(function() {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add/{product:slug}', [CartController::class, 'add']);
        Route::post('/remove/{product:slug}', [CartController::class, 'remove']);
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity']);
    });
});

//--------------------------------------------------------------------------//
Route::middleware(['api'])->group(function () {
    // Public routes that don't require authentication
    Route::get('products', [ProductIndexingController::class, 'index']);
    Route::get('products/{product:slug}', [ProductIndexingController::class, 'show']);



});
//----------------------------------------------------------------------------------//

Route::middleware(['auth:sanctum' ,'role:admin'])->prefix('')->group(function () {

    Route::apiResource('dashboard/products',ProductController::class);
});


Route::get('/dam', [CartController::class, 'dam']);

Route::get('/get-cookie', function (Request $request) {
    $value = $request->cookie('name');
    return response()->json(['cookie_value' => $value]);
});
