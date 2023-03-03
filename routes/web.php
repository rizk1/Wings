<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/list-product');
});

Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'actionlogin']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'actionRegister']);

Route::post('/logout', [AuthController::class, 'actionlogout']);

Route::middleware(['isLogin'])->group(function () {
    Route::get('/list-product', [ProductController::class, 'index']);
    Route::get('/product/{id}', [ProductController::class, 'detail']);

    Route::get('/cart', function () {
        return view('cart.cart');
    });
    Route::get('/cart-product', [ProductController::class, 'getCartProduct']);
    Route::post('/checkout', [ProductController::class, 'Checkout']);

    Route::get('/sales-report', [ProductController::class, 'salesReport']);
});