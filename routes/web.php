<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MejaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Pelanggan\PesanController;
use Illuminate\Support\Facades\Route;

// Route untuk login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk logout

// Route untuk admin (hanya bisa diakses oleh pengguna yang sudah login dan memiliki role admin)
Route::prefix('admin')->name('admin.')->middleware(['check.admin'])->group(function () {
    Route::get('meja', [MejaController::class, 'index'])->name('meja.index');
    Route::get('meja/create', [MejaController::class, 'create'])->name('meja.create');
    Route::post('meja', [MejaController::class, 'store'])->name('meja.store');
    Route::get('meja/{id}/edit', [MejaController::class, 'edit'])->name('meja.edit');
    Route::put('meja/{id}', [MejaController::class, 'update'])->name('meja.update');
    Route::delete('meja/{id}', [MejaController::class, 'destroy'])->name('meja.destroy');

    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
});


Route::get('/kasir', function () {
    return 'Halaman Kasir';
});

Route::get('/dapur', function () {
    return 'Halaman Dapur';
});


// Route untuk pelanggan (akses melalui QR Code), bisa diakses secara publik
Route::get('pesan/{nomor_meja}', [PesanController::class, 'index'])->name('pesan.index');
