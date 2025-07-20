<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\PosController;

Route::get('/', function () {
    return view(view: 'auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User management routes for admins (inside profile)
    Route::middleware(['role:Admin'])->group(function () {
        Route::post('/profile/users', [ProfileController::class, 'storeUser'])->name('profile.users.store');
        Route::patch('/profile/users/{targetUser}', [ProfileController::class, 'updateUser'])->name('profile.users.update');
        Route::delete('/profile/users/{targetUser}', [ProfileController::class, 'destroyUser'])->name('profile.users.destroy');
    });

    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', App\Http\Controllers\CategoryController::class);
        Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
        // Rute untuk Pembelian
        Route::post('purchases/{purchase}/add-item', [PurchaseController::class, 'addItem'])->name('purchases.addItem');
        Route::post('purchases/{purchase}/complete', [PurchaseController::class, 'complete'])->name('purchases.complete');
        Route::resource('purchases', PurchaseController::class);
    });
    Route::get('/deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    Route::post('/deliveries/{order}/status', [DeliveryController::class, 'updateStatus'])->name('deliveries.updateStatus');
    Route::get('/deliveries/{order}/details', [DeliveryController::class, 'details'])->name('deliveries.details');
    Route::get('/debts', [DebtController::class, 'index'])->name('debts.index');
    Route::patch('/debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay');
    Route::get('/debts/{debt}/details', [DebtController::class, 'details'])->name('debts.details');

    Route::get('/pos', [PosController::class, 'index'])
        ->name('pos.index')
        ->middleware('role:Admin|Kasir');

    Route::post('/pos/update-cart', [PosController::class, 'updateCart'])
        ->name('pos.update-cart')
        ->middleware('role:Admin|Kasir');

    Route::get('/pos/checkout', [PosController::class, 'checkout'])
        ->name('pos.checkout.get')
        ->middleware('role:Admin|Kasir');

    Route::post('/pos/checkout', [PosController::class, 'checkout'])
        ->name('pos.checkout')
        ->middleware('role:Admin|Kasir');    Route::get('/receipt/order/{order}', [ReceiptController::class, 'show'])
        ->name('receipt.show')
        ->middleware('role:Admin|Kasir');

    Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);
    });

require __DIR__.'/auth.php';


