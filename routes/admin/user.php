<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::group([], function () {
    Route::resources([
        'user' => UserController::class,
    ]);
});