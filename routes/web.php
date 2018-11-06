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
});

Route::group(['middleware' => ['auth','no.back']], function() {
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
    Route::get('receive-items', 'Pages\ReceiveItemController@index');
    Route::get('update-inventory', 'Pages\UpdateInventoryController@index');

    Route::get('dropdown','Pages\DropdownController@index');
    Route::get('dropdown/show-name','Pages\DropdownController@show_name');
    Route::get('dropdown/show-option','Pages\DropdownController@show_option');
    Route::post('dropdown/save-name','Pages\DropdownController@save_name');
    Route::post('dropdown/save-option','Pages\DropdownController@save_option');
    Route::post('dropdown/delete','Pages\DropdownController@destroy');

    Route::get('get-province', 'GlobalController@getProvince');
    Route::get('get-city', 'GlobalController@getCity');
    Route::get('get-modules', 'GlobalController@getModules');
    Route::get('get-referrer', 'GlobalController@referrers');
    Route::get('get-language', 'GlobalController@getLanguage');
    Route::post('translate-language', 'GlobalController@translateLanguage');
});
