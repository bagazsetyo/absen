<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QrcodeController;

Route::group([], function () {
    Route::controller(QrcodeController::class)
        ->group(function () {
            Route::get('/', 'index')->name('dashboard');
        });

});