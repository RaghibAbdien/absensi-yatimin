<?php

use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PenggunaController::class, 'showPengguna'])->name('presensi.index');
Route::post('/save-photo', [PenggunaController::class, 'savePhoto']);
Route::post('/store-yatimin', [PenggunaController::class, 'store'])->name('store-yatimin');
Route::post('/update-status', [PenggunaController::class, 'updateStatus']);
