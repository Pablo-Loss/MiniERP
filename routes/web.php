<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SkuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('products.index');
});

Route::resource('products', ProductsController::class)->except(['show']);

Route::delete('/skus/{sku}', [SkuController::class, 'destroy'])->name('skus.destroy');

Route::get('/products/{product}/skus', function (Product $product) {
    return response()->json($product->skus);
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{sku}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/webhook/order-status', [OrderController::class, 'updateStatusFromWebhook']);

Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');
