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
    // 1. Dapatkan role user
    $role = Auth::user()->role;

    // 2. Logika percabangan
    if ($role === 'admin') {
        // [PERUBAHAN DI SINI]
        // Jangan return view, tapi redirect ke Route Livewire Admin
        // Ini akan memicu logic di file Livewire/Admin/Dashboard.php
        return redirect()->route('admin.overview'); 
    } else {
        // Jika Staf, tetap tampilkan view staf biasa
        return view('staff.dashboard');
    }
}
}