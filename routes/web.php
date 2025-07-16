<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // Tambahkan di atas
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController; // Tambahkan ini
use App\Http\Controllers\SupplierController; // Tambahkan ini
use App\Http\Controllers\PurchaseController; // Tambahkan ini
use App\Http\Controllers\DeliveryController; // Tambahkan ini
use App\Http\Controllers\ReceiptController; // Tambahkan ini
use App\Http\Controllers\DebtController; // Tambahkan ini
use App\Http\Controllers\MidtransCallbackController;



Route::get('/', function () {
    return view(view: 'auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['role:Admin'])->group(function () {
        // routes/web.php
    Route::resource('users', UserController::class); // Tambahkan ini


        Route::resource('products', ProductController::class);
        Route::resource('categories', App\Http\Controllers\CategoryController::class); // Tambahkan ini
        Route::resource('products', ProductController::class);
        Route::resource('categories', App\Http\Controllers\CategoryController::class);
        Route::resource('suppliers', App\Http\Controllers\SupplierController::class); // Tambahkan ini
        // Tambahkan rute untuk modul lain di sini nanti
        // Rute untuk Pembelian
        Route::post('purchases/{purchase}/add-item', [PurchaseController::class, 'addItem'])->name('purchases.addItem');
        Route::post('purchases/{purchase}/complete', [PurchaseController::class, 'complete'])->name('purchases.complete');
        Route::resource('purchases', PurchaseController::class);
        // Rute untuk Pengiriman

    });
    Route::get('/deliveries', [DeliveryController::class, 'index'])->name('deliveries.index');
    Route::post('/deliveries/{order}/update-status', [DeliveryController::class, 'updateStatus'])->name('deliveries.updateStatus');
    Route::get('/debts', [DebtController::class, 'index'])->name('debts.index');
    Route::patch('/debts/{debt}/pay', [DebtController::class, 'pay'])->name('debts.pay');

    Route::get('/pos', \App\Livewire\PosComponent::class)
        ->name('pos.index')
        ->middleware('role:Admin|Kasir');

    Route::get('/receipt/order/{order}', [ReceiptController::class, 'show'])
        ->name('receipt.show')
        ->middleware('role:Admin|Kasir');

    Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);
    });

require __DIR__.'/auth.php';


