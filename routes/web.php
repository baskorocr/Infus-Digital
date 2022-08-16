<?php

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

Route::get('/', [App\Http\Controllers\View::class, 'index'])->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/device', [App\Http\Controllers\addDeviceController::class, 'index'])->middleware('auth')->name('device');
Route::post('update', [App\Http\Controllers\UpdateController::class, 'update']);
Route::post('devices',[App\Http\Controllers\addDeviceController::class, 'post']);
