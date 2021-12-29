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
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\UserDistributionController;
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
    
    Route::resource('/users', UserController::class);
    Route::post('quickupdate/user/status/{id}',[UserController::class,'status_update'])->name('user.status.update');

    Route::resource('roles', RoleController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('hsn', HsnController::class);
    Route::resource('gst', GstPercentController::class);
    Route::resource('item', ItemController::class);
    Route::resource('stocks', StockController::class);
    Route::resource('vendors', VendorController::class);  
    Route::resource('stock-distributions', DistributionController::class); 
     
    Route::get('users-stock/list', [UserDistributionController::class,'users_stock_list'])->name('users-stock.list');
    Route::resource('local-stock-distribution', UserDistributionController::class);
    
    Route::get('invoice/setting',[SettingController::class, 'invoice_master'])->name('invoice.master');
    
});

// apis or not included in permission
Route::group(['middleware' => ['auth']],function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/get/items/by/category',[StockController::class, 'get_items_by_category'])->name('category.items');
    Route::get('/get/items/details',[StockController::class, 'get_items_details'])->name('item.details');
    Route::get('/delete/item/photo/{id}',[ItemController::class, 'delete_item_photo'])->name('delete.item.photo');

    // invoice
    Route::post('invoice/setting',[SettingController::class, 'save_invoice_master'])->name('save.invoice.master');

    Route::get('get/users/by/role',[DistributionController::class,'get_user'])->name('role.user');
    Route::get('get/stock/item/details',[DistributionController::class,'get_stock_item_detail'])->name('stock.item.detail');

    Route::get('print/invoice/{id}',[DistributionController::class,'print_invoice'])->name('print.invoice');
    Route::get('print/singleinvoice/{id}',[DistributionController::class,'print_single_invoice'])->name('print.singleinvoice');
    
    Route::get('print/local/invoice/{id}',[UserDistributionController::class,'print_invoice'])->name('print.local.invoice');
    Route::get('print/local/singleinvoice/{id}',[UserDistributionController::class,'print_single_invoice'])->name('print.local.singleinvoice');

});
