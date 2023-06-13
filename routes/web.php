<?php

use App\Http\Controllers\Admin\AngkatanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('angkatan', [AngkatanController::class, 'index'])->name('index');
Route::get('angkatan/create', [AngkatanController::class, 'create'])->name('create');
// Route::get('angkatan/{id}', [AngkatanController::class, 'show'])->name('show');
// Route::post('angkatan/store', [AngkatanController::class, 'store'])->name('store');
// Route::get('angkatan/{id}/edit', [AngkatanController::class, 'edit'])->name('edit');
// Route::put('angkatan/{id}/update', [AngkatanController::class, 'update'])->name('update');
// Route::delete('angkatan/destroy', [AngkatanController::class, 'destroy'])->name('destroy');


Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::group([], __DIR__ . '/admin/dashboard.php');
        Route::group([], __DIR__ . '/admin/qrcode.php');
        Route::group([], __DIR__ . '/admin/angkatan.php');
        Route::group([], __DIR__ . '/admin/user.php');
        Route::group([], __DIR__ . '/admin/kelas.php');
        Route::group([], __DIR__ . '/admin/matkul.php');
    });
