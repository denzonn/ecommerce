<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryGeneralDataController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductReviewController;
use App\Http\Controllers\Api\ProductTypeController;
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

Route::post('login', [AuthController::class, 'login']);
Route::get('category', [CategoryController::class, 'index']);
Route::get('product', [ProductController::class, 'index']);
Route::get('product-review', [ProductReviewController::class, 'index']);
Route::get('product-type', [ProductTypeController::class, 'index']);
Route::get('category-general-data', [CategoryGeneralDataController::class, 'index']);

Route::middleware(['auth:api'])->group(function () {

    // Category Products
    Route::post('category/create', [CategoryController::class, 'store']);
    Route::get('category/edit/{slug}', [CategoryController::class, 'edit']);
    Route::put('category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy']);

    // Category General Data
    Route::post('category-general-data/create', [CategoryGeneralDataController::class, 'store']);
    Route::get('category-general-data/edit/{id}', [CategoryGeneralDataController::class, 'edit']);
    Route::put('category-general-data/update/{id}', [CategoryGeneralDataController::class, 'update']);
    Route::delete('category-general-data/destroy/{id}', [CategoryGeneralDataController::class, 'destroy']);

    // Products Type
    Route::post('product-type/create', [ProductTypeController::class, 'store']);
    Route::get('product-type/edit/{id}', [ProductTypeController::class, 'edit']);
    Route::put('product-type/update/{id}', [ProductTypeController::class, 'update']);
    Route::delete('product-type/destroy/{id}', [ProductTypeController::class, 'destroy']);

    // Products
    Route::post('product/create', [ProductController::class, 'store']);
    Route::get('product/edit/{slug}', [ProductController::class, 'edit']);
    Route::put('product/update/{id}', [ProductController::class, 'update']);
    Route::delete('product/destroy/{id}', [ProductController::class, 'destroy']);

    // Products
    Route::post('product-review/create', [ProductReviewController::class, 'store']);
    Route::get('product-review/edit/{slug}', [ProductReviewController::class, 'edit']);
    Route::put('product-review/update/{id}', [ProductReviewController::class, 'update']);
    Route::delete('product-review/destroy/{id}', [ProductReviewController::class, 'destroy']);

    // Cart
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/create', [CartController::class, 'store']);
    Route::post('cart/increment', [CartController::class, 'increment']);
    Route::post('cart/decrement', [CartController::class, 'decrement']);
    Route::delete('cart/destroy/{id}', [CartController::class, 'destroy']);

    // Billing
    Route::get('billing', [BillingController::class, 'index']);
    Route::post('billing/create', [BillingController::class, 'store']);
});
