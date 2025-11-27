<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\BorrowingRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // 1. Statistik Personal
        $activeLoans = BorrowingRequest::where('user_id', $userId)
            ->where('status', 'Disetujui') // Barang sedang dipegang
            ->count();

        $pendingRequests = BorrowingRequest::where('user_id', $userId)
            ->where('status', 'Pending') // Menunggu Admin
            ->count();

        $completedHistory = BorrowingRequest::where('user_id', $userId)
            ->where('status', 'Selesai') // Sudah dikembalikan & verif
            ->count();

        // 2. Data Terbaru (Agar user langsung lihat status request terakhirnya)
        $recentRequests = BorrowingRequest::with('asset')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        // ---  DATA UNTUK GRAFIK ---

        // GRAFIK 1: Komposisi Status Request Saya
        $statusStats = BorrowingRequest::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $chartStatusLabels = $statusStats->pluck('status');
        $chartStatusValues = $statusStats->pluck('total');

        // GRAFIK 2: Kategori Aset yang Saya Pinjam
        // Kita perlu melakukan JOIN tabel karena BorrowingRequest tidak punya kolom category_id langsung
        $categoryStats = BorrowingRequest::join('assets', 'borrowing_requests.asset_id', '=', 'assets.id')
            ->join('categories', 'assets.category_id', '=', 'categories.id')
            ->where('borrowing_requests.user_id', $userId)
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->get();

        $chartCategoryLabels = $categoryStats->pluck('name');
        $chartCategoryValues = $categoryStats->pluck('total');

        return view('livewire.staff.dashboard', [
            'activeLoans' => $activeLoans,
            'pendingRequests' => $pendingRequests,
            'completedHistory' => $completedHistory,
            'recentRequests' => $recentRequests,
            
            // Kirim variable grafik ke View
            'chartStatusLabels' => $chartStatusLabels,
            'chartStatusValues' => $chartStatusValues,
            'chartCategoryLabels' => $chartCategoryLabels,
            'chartCategoryValues' => $chartCategoryValues,
        ]);
    }
}
