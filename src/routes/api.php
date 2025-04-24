<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'confirmEmail'])->middleware(['signed', 'auth:sanctum'])->name('verification.verify');

Route::post('email/verification-notification', [AuthController::class, 'verificationNotification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
        Route::put('categories/image/{category}', [CategoryController::class, 'updateImage']);

        Route::apiResource('discounts', DiscountController::class)->except(['index', 'show']);

        Route::apiResource('coupons', CouponController::class)->except(['index', 'show']);

        Route::get('coupons/disabled', [CouponController::class, 'disabledCoupons']);
        Route::put('coupons/{coupon}/renew', [CouponController::class, 'renewCoupon']);


        Route::post('users/create-moderator', [UserController::class, 'storeModerator']);
    });

    Route::middleware('role:admin,moderator')->group(function () {
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        Route::put('products/{product}/stock', [ProductController::class, 'updateStock']);
        Route::put('products/image/{product}', [ProductController::class, 'updateImage']);

        Route::get('relatory/orders', [OrderController::class, 'relatoryWeekly']);

        Route::put('orders/{order}', [OrderController::class, 'update']);
    });

    Route::get('users/me', [UserController::class, 'showMe']);
    Route::put('users/me', [UserController::class, 'updateMe']);
    Route::delete('users/me', [UserController::class, 'deleteMe']);
    Route::put('users/image', [UserController::class, 'updateImage']);
    Route::get('users/image', [UserController::class, 'showImage']);

    Route::apiResource('address', AddressController::class);

    Route::get('cart', [CartController::class, 'index']);
    Route::get('cart/items', [CartController::class, 'show']);
    Route::post('cart/items', [CartController::class, 'store']);
    Route::put('cart/items', [CartController::class, 'update']);
    Route::delete('cart/items', [CartController::class, 'deleteItem']);
    Route::delete('cart/clear', [CartController::class, 'clear']);

    Route::apiResource('orders', OrderController::class)->except(['update']);
});

Route::get('categories/image/{category}', [CategoryController::class, 'showImage']);
Route::get('products/image/{product}', [ProductController::class, 'showImage']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{discount}', [DiscountController::class, 'show']);

Route::get('coupons', [CouponController::class, 'index']);
Route::get('coupons/{coupon}', [CouponController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('products/category/{category}', [ProductController::class, 'indexByCategory']);
