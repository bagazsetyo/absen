<?php

use App\Http\Controllers\Admin\AngkatanController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::resources([
        'angkatan' => AngkatanController::class,
    ]);
});