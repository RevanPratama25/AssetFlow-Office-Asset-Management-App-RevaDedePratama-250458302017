<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Verify;
use App\Livewire\Auth\Register;
use App\Livewire\Staff\MyAssets;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Maintenance;
use App\Livewire\Staff\AssetCatalog;
use App\Livewire\Staff\ReportDamage;
use App\Livewire\Admin\ReturnManager;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\BorrowingManager;
use App\Livewire\Auth\Passwords\Confirm;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationController;

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
Route::middleware(['auth'])->group(function () {
    // Ini route utama setelah login
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

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
    
    // Rute Livewire Dashboard yang SEBENARNYA (yang punya statistik)
    // Kita beri nama 'overview' atau tetap 'dashboard' tapi di dalam prefix admin
    Route::get('/overview', Dashboard::class)->name('overview');

    // Rute Manajemen Kategori
    Route::get('/categories', \App\Livewire\Admin\CategoryManager::class)
         ->name('categories.index');

    // Rute Manajemen Lokasi
    Route::get('/locations', \App\Livewire\Admin\LocationManager::class)
         ->name('locations.index');

    // Rute Manajemen Aset
    Route::get('/assets', \App\Livewire\Admin\AssetManager::class)
         ->name('assets.index');

    // Rute Manajemen Pengguna
    Route::get('/users', \App\Livewire\Admin\UserManager::class)
        ->name('users.index');

    // Rute Verifikasi Peminjaman
    Route::get('/borrowings', BorrowingManager::class)
        ->name('admin.borrowings');

    // Rute Verifikasi Pengembalian
    Route::get('/returns', ReturnManager::class)
        ->name('admin.returns');

    // Rute Manajemen Maintenance
    Route::get('/maintenance', Maintenance::class)
        ->name('admin.maintenance');

    // Laporan PDF Peminjaman Aset
    Route::get('/reports/borrowing', \App\Livewire\Admin\Reports\BorrowingReport::class)->name('reports.borrowing');
    //Tambahkan rute admin lainnya di sini..

});

// === GROUP ROUTE UNTUK STAF ===
// Menggunakan middleware 'auth' (harus login) DAN 'staff' (harus staf)
Route::middleware(['auth'])->group(function () {

    // Rute Dashboard Staff
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('staff.dashboard');

    // Katalog Aset
    Route::get('/staff/assets', AssetCatalog::class)
        ->name('staff.assets');

    // Aset Staff
    Route::get('/staff/my-assets', MyAssets::class)
        ->name('staff.my-assets');

    // Lapor Kerusakan Aset
    Route::get('/staff/report-damage', ReportDamage::class)
        ->name('staff.report_damage');
});
