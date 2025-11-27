<?php

namespace App\Livewire\Admin;

use App\Models\Asset;
use Livewire\Component;
use App\Models\Category;
use App\Models\BorrowingRequest;
use App\Models\MaintenanceLog; // Jika ingin hitung log maintenance aktif
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // --- DATA UNTUK GRAFIK 1: Status Aset (Pie Chart) ---
        // Hasilnya: Collection [{'status': 'Tersedia', 'total': 10}, {'status': 'Rusak', 'total': 2}, ...]
        $assetsByStatus = Asset::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        // Kita format agar mudah dibaca Chart.js (Pisahkan Label dan Data)
        $chartStatusLabels = $assetsByStatus->pluck('status');
        $chartStatusValues = $assetsByStatus->pluck('total');


        // --- DATA UNTUK GRAFIK 2: Aset per Kategori (Bar Chart) ---
        // Kita ambil kategori beserta jumlah asetnya
        $assetsByCategory = Category::withCount('assets')->get();
        
        $chartCategoryLabels = $assetsByCategory->pluck('name');
        $chartCategoryValues = $assetsByCategory->pluck('assets_count');

        // 1. Statistik Aset
        $totalAssets = Asset::count();
        $availableAssets = Asset::where('status', 'Tersedia')->count();
        $borrowedAssets = Asset::where('status', 'Dipinjam')->count();
        
        // Sesuaikan string ini dengan status yang Anda pakai tadi ("Dalam Perbaikan" atau "Maintenance")
        $maintenanceAssets = Asset::whereIn('status', ['Maintenance', 'Dalam Perbaikan', 'Rusak'])->count();

        // 2. Statistik Transaksi (Action Needed)
        $pendingRequests = BorrowingRequest::where('status', 'Pending')->count();
        $activeLoans = BorrowingRequest::where('status', 'Disetujui')->count();

        // 3. Aktivitas Terbaru (5 transaksi terakhir)
        $recentActivities = BorrowingRequest::with(['user', 'asset'])
            ->latest() // alias order by created_at desc
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'totalAssets' => $totalAssets,
            'availableAssets' => $availableAssets,
            'borrowedAssets' => $borrowedAssets,
            'maintenanceAssets' => $maintenanceAssets,
            'pendingRequests' => $pendingRequests,
            'activeLoans' => $activeLoans,
            'recentActivities' => $recentActivities,
            // ... variabel untuk grafik ...
            'chartStatusLabels' => $chartStatusLabels,
            'chartStatusValues' => $chartStatusValues,
            'chartCategoryLabels' => $chartCategoryLabels,
            'chartCategoryValues' => $chartCategoryValues,
        ])->extends('components.admin-layout');
    }
}