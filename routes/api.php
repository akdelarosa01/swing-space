<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['auth','no.back']], function() {
	Route::apiResource('module','SuperAdmin\ModuleController');
});

