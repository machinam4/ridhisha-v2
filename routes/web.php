<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\RadioController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     dd(now()->subMonth());
//     return view('welcome');
// });
Route::middleware(['auth'])->controller(RadioController::class)->group(function () {
    Route::get('/', 'dashboard')->name('radio_dashboard');
    Route::get('/players', 'players')->name('radio_players');
    Route::get('/online/{index}', 'online')->name('radio_online');
});

Route::prefix('/admin')->middleware(['auth'])/*->middleware('radio')*/->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('/players', 'players')->name('players');
    });

    Route::controller(RadioController::class)->prefix('/radios')->group(function () {
        Route::get('/', 'radios')->name('radios');
        Route::get('/{radio}', 'radio_view')->name('radio_view');
        Route::Post('/add', 'add_radio')->name('add_radio');
        Route::Post('/update/{radio}', 'update_radio')->name('update_radio');
        Route::get('/delete/{radio}', 'delete_radio')->name('delete_radio');
    });

    Route::controller(MpesaController::class)->prefix('/mpesas')->group(function () {
        Route::get('/', 'mpesas')->name('mpesas');
        Route::Post('/add', 'add_mpesa')->name('add_mpesa');
        Route::Post('/update/{mpesa}', 'update_mpesa')->name('update_mpesa');
        Route::get('/delete/{mpesa}', 'delete_mpesa')->name('delete_mpesa');
        Route::get('/registerurl/{mpesa}', 'registerurl')->name('registerurl');
    });
    // 
});
