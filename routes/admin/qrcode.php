<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QrcodeController;

Route::group([], function () {
    Route::resources([
        'qrcode' => QrcodeController::class,
    ]);
});