<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HsnController;
use App\Http\Controllers\GstPercentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockController;
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

Route::get('/', [HomeController::class, 'index']);

Auth::routes();
Route::group(['middleware' => ['auth','has_permission']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/users', UserController::class);
    Route::post('quickupdate/user/status/{id}',[UserController::class,'status_update'])->name('user.status.update');

    Route::resource('roles', RoleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('hsn', HsnController::class);
    Route::resource('gst', GstPercentController::class);
    Route::resource('item', ItemController::class);
    Route::resource('stocks', StockController::class);
    
});