`<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DapurController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\MejaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pelanggan\PesanController;
use App\Http\Controllers\Admin\AdminTransaksiController;

// Route untuk halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Route untuk login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route untuk logout

// Route untuk admin (hanya bisa diakses oleh pengguna yang sudah login dan memiliki role admin)
Route::prefix('admin')->name('admin.')->middleware(['check.admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('meja', [MejaController::class, 'index'])->name('meja.index');
    Route::get('meja/create', [MejaController::class, 'create'])->name('meja.create');
    Route::post('meja', [MejaController::class, 'store'])->name('meja.store');
    Route::delete('meja/{id}', [MejaController::class, 'destroy'])->name('meja.destroy');

    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    Route::get('user',            [UserController::class, 'index'])->name('user.index');
Route::get('user/create',     [UserController::class, 'create'])->name('user.create');
Route::post('user',           [UserController::class, 'store'])->name('user.store');
Route::get('user/{id}/edit',  [UserController::class, 'edit'])->name('user.edit');
Route::put('user/{id}',       [UserController::class, 'update'])->name('user.update');
Route::delete('user/{id}',    [UserController::class, 'destroy'])->name('user.destroy');

Route::get('transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');

});

// kasir
//––––––– KASIR ROUTES –––––––
Route::middleware(['auth', 'check.admin'])
     ->prefix('kasir')
     ->name('kasir.')
     ->group(function () {
         
    // Halaman utama kasir (list/meja/search)
    Route::get('/', [KasirController::class, 'index'])
         ->name('index');
    Route::post('/', [KasirController::class, 'cari'])
         ->name('cari');
    
    // Bayar transaksi
    Route::post('/bayar/{id}', [KasirController::class, 'bayar'])
         ->name('bayar');
});

//––––––– DAPUR ROUTES –––––––
Route::middleware(['auth', 'check.admin'])
     ->prefix('dapur')
     ->name('dapur.')
     ->group(function () {
         
    // Halaman utama dapur (daftar pesanan)
    Route::get('/', [DapurController::class, 'index'])
         ->name('index');
    
    // Proses/meja selesai
    Route::delete('/proses/{nomorMeja}', [DapurController::class, 'prosesMeja'])->name('prosesMeja');
    Route::put('/update/{id}', [DapurController::class, 'updateStatus'])->name('updateStatus');
});




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

Route::post('/keranjang/tambah-jumlah/{menu_id}', [PesanController::class, 'tambahJumlah'])->name('keranjang.tambahJumlah');
Route::post('/keranjang/kurang-jumlah/{menu_id}', [PesanController::class, 'kurangJumlah'])->name('keranjang.kurangJumlah');



// route untuk status pesanan


Route::post('/pesan/close-bill', [PesanController::class, 'closeBill'])->name('pesan.closeBill');

// web.php
Route::post('/close-bill', [PesanController::class, 'closeBill'])->name('order.close');
Route::get('/transaksi/{order_id}', [PesanController::class, 'showTransaksi'])->name('pesan.transaksi');
Route::get('/transaksi/create/{order_id}', [PesanController::class, 'showTransaksi'])->name('transaksi.create');
Route::post('/transaksi/store', [PesanController::class, 'storeTransaksi'])->name('pesan.transaksi.store');




