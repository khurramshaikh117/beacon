<?php

use Illuminate\Support\Facades\Route;
use App\Models\Device;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperationsController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/devices', function () {
    $devices = Device::orderBy('last_seen_at', 'desc')->get();
    return view('devices', compact('devices'));
});

Route::get('/', fn () => redirect()->route('login'));

// Auth (session)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('operations')->name('operations.')->group(function () {
        Route::get('/',            [OperationsController::class, 'index'])->name('index');
        Route::get('/create',      [OperationsController::class, 'create'])->name('create');
        Route::post('/',           [OperationsController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [OperationsController::class, 'edit'])->name('edit');
        Route::put('/{user}',      [OperationsController::class, 'update'])->name('update');
        Route::delete('/{user}',   [OperationsController::class, 'destroy'])->name('destroy');
    });
});
