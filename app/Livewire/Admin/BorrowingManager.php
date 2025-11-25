<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\BorrowingRequest;
use App\Models\Asset;
use Livewire\WithPagination;

class BorrowingManager extends Component
{
    use WithPagination;

    // Aksi: Menyetujui Permintaan
    public function approve($requestId)
    {
        $request = BorrowingRequest::find($requestId);

        if (!$request || $request->status !== 'Pending') {
            session()->flash('error', 'Data tidak valid atau sudah diproses.');
            return;
        }

        // Cek apakah aset masih tersedia (untuk menghindari double booking)
        $asset = Asset::find($request->asset_id);
        if ($asset->status !== 'Tersedia') {
            session()->flash('error', 'Gagal! Aset ini statusnya sudah tidak tersedia (mungkin sudah dipinjam orang lain).');
            return;
        }

        // 1. Update Request jadi Disetujui
        $request->update([
            'status' => 'Disetujui',
            'approved_by_user_id' => auth()->id(), 
            'approved_at' => now(), 
        ]);

        // 2. Update Aset jadi Dipakai & Set Peminjam
        $asset->update([
            'status' => 'Dipakai',
            'current_user_id' => $request->user_id
        ]);

        session()->flash('message', 'Peminjaman berhasil disetujui.');
    }

    // Aksi: Menolak Permintaan
    public function reject($requestId)
    {
        $request = BorrowingRequest::find($requestId);

        if ($request && $request->status === 'Pending') {
            $request->update(['status' => 'Ditolak']);
            session()->flash('message', 'Permintaan peminjaman ditolak.');
        }
    }

    public function render()
    {
        // Tampilkan hanya yang statusnya Pending (Prioritas untuk diproses)
        // Anda bisa menghapus where('status', 'Pending') jika ingin melihat history semua
        $requests = BorrowingRequest::with(['user', 'asset'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'asc') // Yang lama diproses duluan (FIFO)
            ->paginate(10);

        return view('livewire.admin.borrowing-manager', [
            'requests' => $requests
        ])->extends('components.admin-layout'); 
    }
}