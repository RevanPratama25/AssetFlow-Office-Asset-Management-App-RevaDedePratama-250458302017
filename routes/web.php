<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/', 'welcome')->name('home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)
        ->name('logout');
});

// === GROUP ROUTE UNTUK ADMIN ===
// Menggunakan middleware 'auth' (harus login) DAN 'admin' (harus admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute Dashboard Admin (contoh: /admin/dashboard)
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
         ->name('dashboard');

    // Rute Manajemen Kategori
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)
         ->name('categories.index');

    // Rute Manajemen Lokasi
    Route::get('/locations', \App\Livewire\Admin\LocationManager::class)
         ->name('locations.index');


    // Rute Manajemen Aset
    Route::get('/assets', \App\Livewire\Admin\AssetManager::class)
         ->name('assets.index');
    //Tambahkan rute admin lainnya di sini...

});
