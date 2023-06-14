<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::resources([
        'role' => RoleController::class,
    ]);
});