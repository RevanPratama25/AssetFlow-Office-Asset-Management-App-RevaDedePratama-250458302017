<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Asset;
use App\Models\BorrowingRequest;
use App\Models\MaintenanceLog; // Jika ingin hitung log maintenance aktif

class Dashboard extends Component
{
    public function render()
    {
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
            'recentActivities' => $recentActivities
        ])->extends('components.admin-layout');
    }
}