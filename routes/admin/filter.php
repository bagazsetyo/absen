<?php

use App\Http\Controllers\Admin\FilterController;
use Illuminate\Support\Facades\Route;

Route::controller(FilterController::class)
        ->as('filter.')
        ->prefix('filter')
        ->group(function(){
            Route::post('kelas', 'kelas')->name('kelas');
            Route::post('angkatan', 'angkatan')->name('angkatan');
            Route::post('matkul', 'matkul')->name('matkul');
            Route::get('kelas', 'selectKelas')->name('select.kelas');
            Route::get('angkatan', 'selectAngkatan')->name('select.angkatan');
            Route::get('matkul', 'selectMatkul')->name('select.matkul');
    });