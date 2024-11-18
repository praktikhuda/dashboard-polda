<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TableController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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



Route::get('/', [AuthController::class, 'index'])->name('auth.login');
Route::prefix('auth')
->group(function () {
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/reloadCaptcha', [AuthController::class, 'reloadCaptcha'])->name('auth.reloadCaptcha');
});


Route::prefix('modal')->group(function () {
    Route::get('/modal', function () {return view('pages.modal.modal-v1');})->name('modal');
    Route::get('/modal-v2', function () {return view('pages.modal.modal-v2');})->name('modal-v2');
    Route::get('/modal-v3', function () {return view('pages.modal.modal-v3');})->name('modal-v3');
    Route::get('/toast-v1', function () {return view('pages.modal.toast');})->name('toast-v1');
});

Route::middleware(['auth.user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/table', [TableController::class, 'index'])->name('table');
    Route::post('/tambah', [TableController::class, 'tambah'])->name('tambahTable');
    Route::get('/lihat', [TableController::class, 'lihat'])->name('lihatTable');
    Route::get('/cari', [TableController::class, 'cari'])->name('cariTable');
    Route::post('/edit/{id}', [TableController::class, 'edit'])->name('editTable');
    Route::get('/hapus/{id}', [TableController::class, 'hapus'])->name('hapusTable');
    
    
    Route::get('/lihatTable', [TableController::class, 'lihatTable'])->name('lihatTable-v1');
    Route::get('/lihatTable_v2', [TableController::class, 'lihatTable_v2'])->name('lihatTable-v2');
    Route::get('/tambahTable__', [TableController::class, 'tambahTable__'])->name('lihatTable__');
    Route::post('/addTable__', [TableController::class, 'addTable__'])->name('addTable__');
    Route::get('/cariTable__', [TableController::class, 'cariTable__'])->name('cariTable__');
});




Route::get('/datatable', function () {
    return view('cobaDatatable');
});