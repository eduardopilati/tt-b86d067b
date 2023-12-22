<?php

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
 * --------------------------------------------------------------------------
 *  Web Routes
 * --------------------------------------------------------------------------
 *
 * Here is where you can register web routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * contains the "web" middleware group. Now create something great!
 *
 */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('users.')->prefix('users')->group(function (): void {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::post('/', [UsersController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('destroy');
        Route::get('/search', [UsersController::class, 'search'])->name('search');
    });

    Route::name('cars.')->prefix('cars')->group(function (): void {
        Route::get('/', [CarsController::class, 'index'])->name('index');
        Route::get('/create', [CarsController::class, 'create'])->name('create');
        Route::post('/', [CarsController::class, 'store'])->name('store');
        Route::get('/{car}/edit', [CarsController::class, 'edit'])->name('edit');
        Route::put('/{car}', [CarsController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarsController::class, 'destroy'])->name('destroy');
        Route::get('/search', [CarsController::class, 'search'])->name('search');
    });

    Route::name('bookings.')->prefix('bookings')->group(function (): void {
        Route::get('/', [BookingsController::class, 'index'])->name('index');
        Route::get('/create', [BookingsController::class, 'create'])->name('create');
        Route::post('/', [BookingsController::class, 'store'])->name('store');
        Route::delete('/{booking}', [BookingsController::class, 'destroy'])->name('destroy');
        Route::get('/print', [BookingsController::class, 'print'])->name('print');
    });
});

require __DIR__ . '/auth.php';
