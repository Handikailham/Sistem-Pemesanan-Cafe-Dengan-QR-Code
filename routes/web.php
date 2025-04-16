`<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DapurController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\MejaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pelanggan\PesanController;

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




Route::get('/dapur', [DapurController::class, 'index'])->name('dapur.index');
Route::delete('/dapur/proses/{nomorMeja}', [DapurController::class, 'prosesMeja'])->name('dapur.prosesMeja');

Route::put('/dapur/update/{id}', [DapurController::class, 'updateStatus'])->name('dapur.updateStatus');




// Route untuk pelanggan (akses melalui QR Code), bisa diakses secara publik
Route::get('pesan/{nomor_meja}', [PesanController::class, 'index'])->name('pesan.index');

// Route untuk konfirmasi pesanan
Route::post('pesan/confirm', [PesanController::class, 'confirmOrder'])->name('pesan.confirm');

Route::get('pesan/{nomor_meja}', [PesanController::class, 'index'])->name('pesan.index');

// Tambahkan route POST untuk menambah ke keranjang
Route::post('pesan/add', [PesanController::class, 'addToKeranjang'])->name('pesan.add');

// Tambahkan route POST untuk konfirmasi pesanan
Route::post('pesan/confirm', [PesanController::class, 'confirmOrder'])->name('pesan.confirm');

// route ke keranjang
Route::get('keranjang/{nomor_meja}', [PesanController::class, 'keranjang'])->name('keranjang.index');
// edit keranjang
Route::post('/keranjang/update/{id}', [PesanController::class, 'updateKeranjang'])->name('keranjang.update');
// routes/web.php
Route::post('/keranjang/remove/{id}', [PesanController::class, 'remove'])->name('keranjang.remove');


// route untuk status pesanan
Route::get('pesan/{nomor_meja}/status',[PesanController::class, 'status'])->name('pesan.status');

Route::post('/pesan/close-bill', [PesanController::class, 'closeBill'])->name('pesan.closeBill');

// web.php
Route::post('/close-bill', [PesanController::class, 'closeBill'])->name('order.close');
Route::get('/transaksi/{order_id}', [PesanController::class, 'showTransaksi'])->name('pesan.transaksi');
Route::get('/transaksi/create/{order_id}', [PesanController::class, 'showTransaksi'])->name('transaksi.create');
Route::post('/transaksi/store', [PesanController::class, 'storeTransaksi'])->name('pesan.transaksi.store');

// kasir
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir', [KasirController::class, 'cari'])->name('kasir.cari');
Route::post('/kasir/bayar/{id}', [KasirController::class, 'bayar'])->name('kasir.bayar');



