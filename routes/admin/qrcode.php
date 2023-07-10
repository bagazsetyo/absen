<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QrcodeController;

Route::group([], function () {
    Route::resources([
        'qrcode' => QrcodeController::class,
    ]);
    Route::controller(QrcodeController::class)
        ->prefix('qrcode')
        ->as('qrcode.')
        ->group(function(){
            Route::get('create/json', 'createJson')->name('create.json');
            Route::post('create/json', 'storeJson')->name('store.json');
    });
});