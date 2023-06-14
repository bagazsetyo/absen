<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;

Route::group([], function () {
    Route::resources([
        'permission' => PermissionController::class,
    ]);
});