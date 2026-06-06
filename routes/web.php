<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Landing page - redirect based on auth
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect('/admin/dashboard')
            : redirect('/katalog');
    }
    return redirect('/login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [ProdukController::class, 'index'])->name('admin.dashboard');
    Route::resource('produk', ProdukController::class)->names('admin.produk');
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    Route::post('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
});

// Pembeli Routes
Route::middleware('auth')->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
    Route::get('/katalog/{produk}', [KatalogController::class, 'show'])->name('katalog.show');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkoutForm');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('pembeli.peminjaman.index');
});
