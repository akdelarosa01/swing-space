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
});
