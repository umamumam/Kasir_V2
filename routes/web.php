<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupliyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenerimaanController;

// Route::get('/', function () {
//     return view('login');
// });

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::resource('/menus', MenuController::class);
Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login']);

// Halaman registrasi
Route::get('register', [AuthController::class, 'showRegisterForm']);
Route::post('register', [AuthController::class, 'register']);

// Logout
Route::post('logout', [AuthController::class, 'logout']);

Route::resource('kategori', KategoriController::class);
Route::resource('produk', ProdukController::class);
Route::resource('transaksi', TransaksiController::class);
Route::resource('penerimaan', PenerimaanController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
Route::get('/transaksi/{transaksi}/print', [TransaksiController::class, 'print'])->name('transaksi.print');
Route::resource('supliyer', SupliyerController::class);


