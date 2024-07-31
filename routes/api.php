<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

use App\Http\Controllers\Profile\ProfileController;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductIndexingController;


//------------------------------ Login system -----------------------------------------//


Route::middleware(['guest','api'])->group(function () {

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

    Route::post('/reset-password', [NewPasswordController::class, 'store']);

});

//------------------------------ Profile -----------------------------------------//

Route::middleware(['auth:sanctum','role:user'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::prefix('profile')->group(function () {

        Route::post('/update-name',[ProfileController::class, 'updateName']);
        Route::post('/update-password',[ProfileController::class, 'updatePassword']);
        // Route::post('/update-address'); // see how we will add the cities ?

    });
});



//------------------------------ Cart Not User -----------------------------------------//

Route::middleware(['guest','api'])->prefix('guest/cart')->group(function () {

    Route::get('/', [CartController::class, 'index']);
    Route::post('/add/{product:slug}', [CartController::class, 'add']);
    Route::post('/remove/{product:slug}', [CartController::class, 'remove']);
    Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity']);

});


//--------------------------------Cart Auth User + Logout--------------------------------//

Route::middleware(['auth:sanctum','role:user'])->prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index']);
    Route::post('/add/{product:slug}', [CartController::class, 'add']);
    Route::post('/remove/{product:slug}', [CartController::class, 'remove']);
    Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity']);

});

//---------------------------------For all Users-------------------------------------//

Route::middleware(['api'])->group(function () {
    Route::get('products', [ProductIndexingController::class, 'index']);
    Route::get('products/{product:slug}', [ProductIndexingController::class, 'show']);

});
//----------------------------------- Admin -------------------------------------//

Route::middleware(['auth:sanctum' ,'role:admin'])->prefix('')->group(function () {

    Route::apiResource('dashboard/products',ProductController::class);
});


// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//                 ->middleware(['signed', 'throttle:6,1']);

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                 ->middleware(['throttle:6,1']);
