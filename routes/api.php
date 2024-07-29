<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductIndexingController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth System
Route::middleware(['guest','api'])->group(function () {

//------------------------------ Login system -----------------------------------------//

Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

Route::post('/reset-password', [NewPasswordController::class, 'store']);

//------------------------------ Products -----------------------------------------//

    Route::get('products',[ProductIndexingController::class,'index']);
    Route::get('products/{product:slug}',[ProductIndexingController::class,'show']);

});
//----------------------------------------------------------------------------------//

Route::middleware(['auth:sanctum','role:user'])->group(function () {

//----------------------------------------------------------------------------------//

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

// Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//                 ->middleware(['signed', 'throttle:6,1']);

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                 ->middleware(['throttle:6,1']);





});

//----------------------------------------------------------------------------------//

Route::middleware(['auth:sanctum' ,'role:admin'])->prefix('')->group(function () {

    Route::apiResource('dashboard/products',ProductController::class);
});
