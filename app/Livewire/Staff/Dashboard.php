<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\BorrowingRequest;
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

        return view('livewire.staff.dashboard', [
            'activeLoans' => $activeLoans,
            'pendingRequests' => $pendingRequests,
            'completedHistory' => $completedHistory,
            'recentRequests' => $recentRequests
        ]);
    }
}
