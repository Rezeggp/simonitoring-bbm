<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\JenisBbmController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SpbuController;
use App\Http\Controllers\StokDepotController;
use App\Http\Controllers\StokSpbuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master data — hanya admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('depots', DepotController::class)->except('show');
        Route::resource('spbus', SpbuController::class)->except('show');
        Route::resource('jenis-bbm', JenisBbmController::class)->except('show')->parameters(['jenis-bbm' => 'jenisBbm']);
        Route::resource('users', UserController::class)->except('show');
    });

    // Stok depot — admin & operator depot
    Route::middleware('role:admin,operator_depot')->group(function () {
        Route::get('/stok-depot', [StokDepotController::class, 'index'])->name('stok-depot.index');
        Route::get('/stok-depot/create', [StokDepotController::class, 'create'])->name('stok-depot.create');
        Route::post('/stok-depot', [StokDepotController::class, 'store'])->name('stok-depot.store');
        Route::get('/stok-depot/{stokDepot}/edit', [StokDepotController::class, 'edit'])->name('stok-depot.edit');
        Route::put('/stok-depot/{stokDepot}', [StokDepotController::class, 'update'])->name('stok-depot.update');
        Route::delete('/stok-depot/{stokDepot}', [StokDepotController::class, 'destroy'])->name('stok-depot.destroy');
    });

    // Stok SPBU — admin & operator spbu
    Route::middleware('role:admin,operator_spbu')->group(function () {
        Route::get('/stok-spbu', [StokSpbuController::class, 'index'])->name('stok-spbu.index');
        Route::get('/stok-spbu/{stokSpbu}/edit', [StokSpbuController::class, 'edit'])->name('stok-spbu.edit');
        Route::put('/stok-spbu/{stokSpbu}', [StokSpbuController::class, 'update'])->name('stok-spbu.update');
    });

    // ==========================================
    // BAGIAN DISTRIBUSI
    // ==========================================
    Route::get('/distribusi', [DistribusiController::class, 'index'])->name('distribusi.index');

    Route::middleware('role:admin,operator_depot')->group(function () {
        Route::get('/distribusi/create', [DistribusiController::class, 'create'])->name('distribusi.create');
        Route::post('/distribusi', [DistribusiController::class, 'store'])->name('distribusi.store');
        Route::delete('/distribusi/{distribusi}', [DistribusiController::class, 'destroy'])->name('distribusi.destroy');
        Route::patch('/distribusi/{distribusi}/status', [DistribusiController::class, 'updateStatus'])->name('distribusi.update-status');
    });

    Route::get('/distribusi/{distribusi}', [DistribusiController::class, 'show'])->name('distribusi.show');

    // ==========================================
    // BAGIAN LAPORAN & EXPORT CSV
    // ==========================================
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('export.distribusi-csv');
    Route::get('/laporan/export-stok-depot', [LaporanController::class, 'exportStokDepotCsv'])->name('export.stok-depot-csv');
    Route::get('/laporan/export-stok-spbu', [LaporanController::class, 'exportStokSpbuCsv'])->name('export.stok-spbu-csv');
    
    // Fitur Backup khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/laporan/backup-database', [LaporanController::class, 'backupDatabase'])->name('export.backup-database');
    });

}); // Penutup Route::middleware('auth')