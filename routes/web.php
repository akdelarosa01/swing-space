<?php

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




Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth','no.back']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth','no.back','admin']], function() {
    Route::get('module','SuperAdmin\ModuleController@index');
    Route::get('module/show','SuperAdmin\ModuleController@show');
    Route::post('module/save','SuperAdmin\ModuleController@save');
    Route::post('module/delete','SuperAdmin\ModuleController@destroy');

    Route::get('transaction-codes','SuperAdmin\TransactionCodesController@index');
    Route::get('transaction-codes/show','SuperAdmin\TransactionCodesController@show');
    Route::post('transaction-codes/save','SuperAdmin\TransactionCodesController@save');
    Route::post('transaction-codes/delete','SuperAdmin\TransactionCodesController@destroy');

    Route::get('user-master','SuperAdmin\UserMasterController@index');
    Route::get('user-master/show','SuperAdmin\UserMasterController@show');
    Route::post('user-master/save','SuperAdmin\UserMasterController@save');
    Route::post('user-master/delete','SuperAdmin\UserMasterController@destroy');
    Route::post('user-master/assign-access','SuperAdmin\UserMasterController@assign_access');
});

Route::group(['middleware' => ['auth','no.back']], function() {
    Route::get('pos-control', 'Pages\POSControlController@index');
    Route::get('pos-control/product-types', 'Pages\POSControlController@product_types');
    Route::get('pos-control/products', 'Pages\POSControlController@show_products');
    Route::post('pos-control/current-customer', 'Pages\POSControlController@save_currentCustomer');
    Route::get('pos-control/check-in-member', 'Pages\POSControlController@check_in_member');
    Route::get('pos-control/show-customer', 'Pages\POSControlController@show_currentCustomer');
    Route::get('pos-control/show-discounts', 'Pages\POSControlController@show_discounts');
    Route::get('pos-control/show-rewards', 'Pages\POSControlController@show_rewards');

    Route::post('pos-control/save-current-bill', 'Pages\POSControlController@save_currentBill');
    Route::post('pos-control/show-current-bill', 'Pages\POSControlController@show_currentBill');
    Route::post('pos-control/delete-current-item', 'Pages\POSControlController@delete_currentItemBill');
    Route::post('pos-control/update-current-item', 'Pages\POSControlController@update_currentItemBill');
    Route::post('pos-control/save-payments', 'Pages\POSControlController@save_payments');

    Route::get('pos-control/customer-view', function() {
        return view('pages.pos.customer_view');
    });

    Route::get('customer-list', 'Pages\CustomerController@index');
    Route::get('customer-list/show', 'Pages\CustomerController@show');
    Route::post('customer-list/delete', 'Pages\CustomerController@destroy');

    Route::get('membership', 'Pages\MembershipController@index');
    Route::get('membership/{id}/edit', 'Pages\MembershipController@edit');
    Route::get('membership/show', 'Pages\MembershipController@show');
    Route::post('membership/save', 'Pages\MembershipController@save');

    Route::get('employee-list', 'Pages\EmployeeController@index');
    Route::get('employee-show-list', 'Pages\EmployeeController@show_list');
    Route::get('employee-list/show', 'Pages\EmployeeController@show');

    Route::get('employee', 'Pages\EmployeeController@registration');
    Route::get('employee/{id}/edit', 'Pages\EmployeeController@edit');
    Route::get('employee/show', 'Pages\EmployeeController@show');
    Route::post('employee/save', 'Pages\EmployeeController@save');
    Route::post('employee/delete', 'Pages\EmployeeController@destroy');

    Route::get('inventory-list', 'Pages\InventoryController@index');
    Route::get('inventory-list/search-items', 'Pages\InventoryController@search_items');
    Route::get('inventory-files', 'Pages\InventoryController@export_files');

    Route::get('summary-list', 'Pages\InventoryController@summary_list');
    Route::get('summary-list/search-items', 'Pages\InventoryController@search_summary_items');

    Route::get('receive-items', 'Pages\ReceiveItemController@index');
    Route::post('receive-items/save', 'Pages\ReceiveItemController@save');
    Route::get('receive-items/search-item', 'Pages\ReceiveItemController@search_items');
    Route::post('receive-items/save-selected', 'Pages\ReceiveItemController@save_selected');
    Route::post('receive-items/upload-inventory', 'Pages\ReceiveItemController@upload_inventory');
    Route::get('receive-items/download-format', 'Pages\ReceiveItemController@download_upload_format');

    Route::get('update-inventory', 'Pages\UpdateInventoryController@index');
    Route::get('update-inventory/search-items', 'Pages\UpdateInventoryController@search_items');
    Route::post('update-inventory/save', 'Pages\UpdateInventoryController@save');

    Route::get('item-output', 'Pages\ItemOutputController@index');
    Route::get('item-output/search-item', 'Pages\ItemOutputController@search_items');
    Route::post('item-output/save-selected', 'Pages\ItemOutputController@save_selected');

    Route::get('product-list', 'Pages\ProductController@index');
    Route::get('product-list/show', 'Pages\ProductController@show');
    Route::get('product-files', 'Pages\ProductController@export_files');
    Route::get('add-products', 'Pages\ProductController@add_products');
    Route::get('add-products/show', 'Pages\ProductController@show');
    Route::get('add-products/search', 'Pages\ProductController@search_products');
    Route::post('add-products/save', 'Pages\ProductController@save');
    Route::post('add-products/set-qty', 'Pages\ProductController@set_qty');

    Route::get('dropdown','Pages\DropdownController@index');
    Route::get('dropdown/show-name','Pages\DropdownController@show_name');
    Route::get('dropdown/show-option','Pages\DropdownController@show_option');
    Route::post('dropdown/save-name','Pages\DropdownController@save_name');
    Route::post('dropdown/save-option','Pages\DropdownController@save_option');
    Route::post('dropdown/delete-option','Pages\DropdownController@destroy_option');

    Route::get('general-settings','Pages\GeneralSettingsController@index');
    Route::post('general-settings/save-incentive','Pages\GeneralSettingsController@save_incentive');
    Route::post('general-settings/delete-incentive','Pages\GeneralSettingsController@delete_incentive');
    Route::get('general-settings/incentives','Pages\GeneralSettingsController@incentives');

    Route::post('general-settings/save-reward','Pages\GeneralSettingsController@save_reward');
    Route::post('general-settings/delete-reward','Pages\GeneralSettingsController@delete_reward');
    Route::get('general-settings/rewards','Pages\GeneralSettingsController@rewards');

    Route::post('general-settings/save-discount','Pages\GeneralSettingsController@save_discount');
    Route::post('general-settings/delete-discount','Pages\GeneralSettingsController@delete_discount');
    Route::get('general-settings/discounts','Pages\GeneralSettingsController@discounts');

    Route::get('get-province', 'GlobalController@getProvince');
    Route::get('get-city', 'GlobalController@getCity');
    Route::get('get-modules', 'GlobalController@getModules');
    Route::get('get-referrer', 'GlobalController@referrers');
    Route::get('get-language', 'GlobalController@getLanguage');
    Route::post('translate-language', 'GlobalController@translateLanguage');
});

Route::get('/logs', 'UserLogsController@getLogs')->name('logs');
