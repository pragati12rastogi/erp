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
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProductChargeController;
use App\Http\Controllers\PushNotificationsController;

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
    Route::resource('expenses', ExpenseController::class); 
    Route::resource('states', StateController::class); 
    Route::resource('districts', DistrictController::class); 
    Route::resource('areas', AreaController::class); 
    Route::resource('product_charge', ProductChargeController::class); 

    Route::get('profit-chart', [ChartController::class,'index'])->name('profit-chart.index'); 
     
    Route::get('users-stock/list', [UserDistributionController::class,'users_stock_list'])->name('users-stock.list');
    Route::resource('local-stock-distribution', UserDistributionController::class);
    
    Route::get('invoice/setting',[SettingController::class, 'invoice_master'])->name('invoice.master');
    Route::get('billing/setting',[SettingController::class, 'billing_master'])->name('billing.master');
    Route::get('email/setting',[SettingController::class, 'email_master'])->name('email-master.index');
    Route::get('sms/setting',[SettingController::class, 'sms_master'])->name('sms.master');
    Route::get('general/setting',[SettingController::class, 'general_master'])->name('general.master');

});

// apis or not included url in permission
Route::group(['middleware' => ['auth']],function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/get/items/by/category',[StockController::class, 'get_items_by_category'])->name('category.items');
    Route::get('/get/items/details',[StockController::class, 'get_items_details'])->name('item.details');
    Route::get('/delete/item/photo/{id}',[ItemController::class, 'delete_item_photo'])->name('delete.item.photo');

    // invoice
    Route::post('invoice/setting',[SettingController::class, 'save_invoice_master'])->name('save.invoice.master');
    Route::post('billing/setting',[SettingController::class, 'save_billing_master'])->name('save.billing.master');
    Route::post('email/setting',[SettingController::class, 'email_master_db'])->name('email.setting.save');
    Route::post('sms/setting',[SettingController::class, 'sms_master_db'])->name('sms.setting.save');
    Route::post('general/setting',[SettingController::class, 'general_master_db'])->name('general.setting.save');

    Route::get('get/users/by/role',[DistributionController::class,'get_user'])->name('role.user');
    Route::get('get/stock/item/details',[DistributionController::class,'get_stock_item_detail'])->name('stock.item.detail');

    Route::get('print/invoice/{id}',[DistributionController::class,'print_invoice'])->name('print.invoice');
    Route::get('print/singleinvoice/{id}',[DistributionController::class,'print_single_invoice'])->name('print.singleinvoice');
    
    Route::get('print/local/invoice/{id}',[UserDistributionController::class,'print_invoice'])->name('print.local.invoice');
    Route::get('print/local/singleinvoice/{id}',[UserDistributionController::class,'print_single_invoice'])->name('print.local.singleinvoice');

    Route::post('distribution/payment/form',[DistributionController::class, 'distribution_payment'])->name('distribution.payment');
    Route::post('local/distribution/payment/form',[UserDistributionController::class, 'distribution_payment'])->name('local.distribution.payment');

    Route::get('download/profit-chart/pdf', [ChartController::class,'download_pdf'])->name('profit-chart.pdf.download'); 
    Route::get('download/users/{type}', [UserController::class,'export_table'])->name('users.export'); 
    Route::get('download/vendors/{type}', [VendorController::class,'export_table'])->name('vendors.export'); 
    
    Route::get('user-profile/update', [UserController::class,'user_profile_update'])->name('userprofile.update');
    Route::post('update/user-profile/password', [UserController::class,'update_user_password'])->name('user.password.update');
    Route::put('user-profile/update/{id}', [UserController::class,'update'])->name('user.profile.db');

    Route::get('state/district/api',[AreaController::class,'getDistrictByState'])->name('state.district.list');
    Route::get('district/area/api',[AreaController::class,'getAreaByDistrict'])->name('district.area.list');
    Route::get('get/item/charge/api',[ProductChargeController::class,'getItemCharge'])->name('district.area.list');
    Route::get('get/user/invoice/setting/api',[SettingController::class,'getUserInvoiceSetting'])->name('user.invoice.setting');
    

    Route::post('request/product',[UserDistributionController::class,'request_product_from_admin'])->name('request.product');
    Route::get('usermarkreadsingle',[PushNotificationsController::class,'usermarkreadsingle'])->name('unreadsinglenotification');
    
});
