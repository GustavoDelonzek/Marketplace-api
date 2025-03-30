<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DiscountController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users/me', [UserController::class, 'showMe']);
    Route::put('users/me', [UserController::class, 'updateMe']);
    Route::delete('users/me', [UserController::class, 'deleteMe']);
    Route::post('users/create-moderator', [UserController::class, 'storeModerator']);
    Route::apiResource('address', AddressController::class);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('discounts', DiscountController::class)->except(['index', 'show']);
    Route::apiResource('coupons', CouponController::class)->except(['index', 'show']);
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::put('products/{product}/stock', [ProductController::class, 'updateStock']);
    Route::get('cart', [CartController::class, 'index']);
    Route::get('cart/items', [CartController::class, 'show']);
    Route::post('cart/items', [CartController::class, 'store']);
    Route::put('cart/items', [CartController::class, 'update']);
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{discount}', [DiscountController::class, 'show']);

Route::get('coupons', [CouponController::class, 'index']);
Route::get('coupons/{coupon}', [CouponController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('products/category/{category}', [ProductController::class, 'indexByCategory']);
