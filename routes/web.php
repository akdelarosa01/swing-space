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

Route::get('qr_code',function() {
    return QRCode::text('SSA006')
                ->setSize(10)
                ->setMargin(1)
                ->setOutfile('qr_codes/SSA006.png')
                ->png();
});

Route::group(['middleware' => ['auth','no.back']], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/purchase-history', 'ProfileController@purchaseHistory');
    Route::get('/profile/qr_code', 'ProfileController@getQRcode');
    Route::get('/profile/qr_code_employee', 'ProfileController@getQRcodeEmployee');
    Route::post('/profile/upload-photo', 'ProfileController@uploadCustomerPhoto');
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

    Route::get('/user-logs','SuperAdmin\UserLogsController@index');
    Route::get('/getlogs', 'SuperAdmin\UserLogsController@getLogs');

    Route::get('wrong-sales-deletion','SuperAdmin\WrongSalesDeletionController@index');
    Route::get('wrong-sales-deletion/get-sold-products','SuperAdmin\WrongSalesDeletionController@getSoldProducts');
    Route::post('wrong-sales-deletion/delete-sold-products','SuperAdmin\WrongSalesDeletionController@deleteSoldProducts');

    Route::get('wrong-sales-deletion/get-sales','SuperAdmin\WrongSalesDeletionController@getSales');
    Route::post('wrong-sales-deletion/delete-sales','SuperAdmin\WrongSalesDeletionController@deleteSales');

    Route::get('wrong-sales-deletion/open-cmd','SuperAdmin\WrongSalesDeletionController@execInBackground');
});

Route::group(['middleware' => ['auth','no.back']], function() {
    Route::get('dashboard/customers-today', 'DashboardController@customersToday');
    Route::get('dashboard/employee-total-statistic', 'DashboardController@EmployeeTotalStatistic');

    Route::get('dashboard/get-sales', 'DashboardController@getSales');
    Route::get('dashboard/owner-total-statistic', 'DashboardController@OwnerTotalStatistic');
    Route::get('dashboard/daily-sales-registered', 'DashboardController@DailySalesFromRegisteredCustomer');
    Route::get('dashboard/daily-sold-products', 'DashboardController@DailySoldProductsPerMonth');
    Route::get('dashboard/sales-registered', 'DashboardController@SalesFromRegisteredCustomer');
    Route::get('dashboard/sold-products', 'DashboardController@SoldProductsPerMonth');

    Route::get('dashboard/customer-bill', 'DashboardController@customerBill');
    Route::get('dashboard/customer-statistic', 'DashboardController@CustomerStatistic');
    Route::get('dashboard/referred-customers', 'DashboardController@referredCustomers');

    Route::get('dashboard/month-sales-report', 'DashboardController@ReportForThisMonth');

    Route::get('pos-control', 'Pages\POSControlController@index');
    Route::get('pos-control/product-types', 'Pages\POSControlController@product_types');
    Route::get('pos-control/products', 'Pages\POSControlController@show_products');
    Route::post('pos-control/current-customer', 'Pages\POSControlController@save_currentCustomer');
    Route::post('pos-control/cancel-customer', 'Pages\POSControlController@cancel_currentCustomer');
    Route::get('pos-control/check-in-member', 'Pages\POSControlController@check_in_member');
    Route::get('pos-control/show-customer', 'Pages\POSControlController@show_currentCustomer');
    Route::get('pos-control/show-discounts', 'Pages\POSControlController@show_discounts');
    Route::get('pos-control/calculate-rewards', 'Pages\POSControlController@calculate_rewards');

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
    Route::get('customer-list/customer-list-excel', 'Pages\CustomerController@customerListExcel');

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
    Route::post('inventory-list/delete', 'Pages\InventoryController@destroy');
    Route::get('inventory-files', 'Pages\InventoryController@export_files');

    Route::get('summary-list', 'Pages\InventoryController@summary_list');
    Route::get('summary-list/search-items', 'Pages\InventoryController@search_summary_items');

    Route::get('receive-items', 'Pages\ReceiveItemController@index');
    Route::get('receive-items/show', 'Pages\ReceiveItemController@show');
    Route::post('receive-items/save', 'Pages\ReceiveItemController@save');
    Route::post('receive-items/delete', 'Pages\ReceiveItemController@destroy');
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
    Route::post('add-products/delete', 'Pages\ProductController@destroy');
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

    Route::post('general-settings/save-promo','Pages\GeneralSettingsController@save_promo');
    Route::post('general-settings/delete-promo','Pages\GeneralSettingsController@delete_promo');
    Route::get('general-settings/promos','Pages\GeneralSettingsController@promos');

    Route::post('general-settings/save-referral-points','Pages\GeneralSettingsController@save_referral_point');
    Route::get('general-settings/referral-points','Pages\GeneralSettingsController@referral_point');

    Route::get('sales-report', 'Pages\SalesReportController@index');
    Route::get('sales-report/get-sales', 'Pages\SalesReportController@sales');
    Route::get('sales-report/yearly-comparison-report', 'Pages\SalesReportController@YearlyComparisonReport');
    Route::get('sales-report/sales-from-customers-report', 'Pages\SalesReportController@SalesFromCustomerReport');
    Route::get('sales-report/sales-over-discounts-report', 'Pages\SalesReportController@SalesOverDiscount');

    Route::get('sales-report/sales-from-customers-excel', 'Pages\SalesReportController@SalesFromCustomerExcel');
    Route::get('sales-report/sales-over-discounts-excel', 'Pages\SalesReportController@SalesOverDiscountExcel');
    Route::get('sales-report/yearly-comparison-excel', 'Pages\SalesReportController@YearlyComparisonExcel');

    Route::get('send-reports', 'Pages\SendReportsController@index');
    Route::post('send-reports/save', 'Pages\SendReportsController@save');



    Route::get('get-province', 'GlobalController@getProvince');
    Route::get('get-city', 'GlobalController@getCity');
    Route::get('get-modules', 'GlobalController@getModules');
    Route::get('get-referrer', 'GlobalController@referrers');
    Route::get('get-language', 'GlobalController@getLanguage');
    Route::post('translate-language', 'GlobalController@translateLanguage');

    Route::get('check-permission', 'GlobalController@check_permission');
});
