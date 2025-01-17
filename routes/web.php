<?php

use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\PaymentController;
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
    return view('welcome');
});



// Route::get('/', [ProductController::class, 'index']);  

Route::get('cart', [ProductController::class, 'cart'])->name('cart');

Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('add.to.cart');

Route::patch('update-cart', [ProductController::class, 'update'])->name('update.cart');

Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove.from.cart');





Route::get('/checkout', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');



Route::get('/payments', [AdminPaymentController::class, 'index'])->name('admin.payments');
Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('admin.payments.approve');
Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('admin.payments.reject');
