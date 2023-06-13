<?php

use App\Http\Controllers\Admin\KelasController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::resources([
        'kelas' => KelasController::class,
    ]);
});