<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

// 1. Pintu Masuk (Tanpa Login)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 2. Area Terlarang (Harus Login)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index']); 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Produk 
    // (Resource ini udah otomatis dapet index, create, store, show, edit, update, destroy)
    Route::resource('produk', ProdukController::class);
    Route::post('/produk/import', [ProdukController::class, 'import'])->name('produk.import');

    // Transaksi
    Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
    Route::post('/penerimaan/simpan', [PenerimaanController::class, 'store'])->name('penerimaan.store');
    Route::resource('pengeluaran', PengeluaranController::class);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/detail/{no_transaksi}', [LaporanController::class, 'show'])->name('laporan.detail');
    Route::get('/laporan/print-nota/{no_transaksi}', [LaporanController::class, 'printNota'])->name('laporan.print');
    Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});