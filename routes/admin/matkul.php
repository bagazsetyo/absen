<?php

use App\Http\Controllers\Admin\MatkulController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::resources([
        'matkul' => MatkulController::class,
    ]);
});