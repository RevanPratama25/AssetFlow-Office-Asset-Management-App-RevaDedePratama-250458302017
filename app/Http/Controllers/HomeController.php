<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // PENTING

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * tambahkan middleware 'auth' di sini,
     * jadi hanya user yang sudah login yang bisa akses controller ini.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * Metode 'index' ini yang akan dipanggil oleh rute /home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Dapatkan role user yang sedang login
        $role = Auth::user()->role;

        // 2. Logika percabangan (Role-Based Routing)
        if ($role === 'admin') {
            // 3. Jika rolenya 'admin', tampilkan view admin
            // (resources/views/admin/dashboard.blade.php)
            return view('admin.dashboard');
        } else {
            // 4. Jika rolenya 'staf' (atau lainnya), tampilkan view staf
            // (resources/views/staf/dashboard.blade.php)
            return view('staff.dashboard');
        }
    }
}