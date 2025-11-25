<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\BorrowingRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class MyAssets extends Component
{
    use WithPagination;

    public function render()
    {
        // Ambil request milik user login, urutkan terbaru, paginate 10
        $myRequests = BorrowingRequest::with('asset') // Eager load relasi asset
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.staff.my-assets', [
            'requests' => $myRequests
        ])->extends('components.staff-layout')
          ->section('content');
    }

    public function cancelRequest($requestId)
    {
        $request = BorrowingRequest::find($requestId);

        // Validasi: Hanya bisa batalkan jika status masih Pending
        if ($request && $request->status == 'Pending') {
            $request->delete(); // Hapus data (Hard Delete)
            session()->flash('message', 'Pengajuan peminjaman berhasil dibatalkan.');
        } else {
            session()->flash('error', 'Pengajuan tidak dapat dibatalkan karena sudah diproses.');
        }
    }

    public function returnAsset($requestId)
    {
        // 1. Cari data peminjaman
        $borrowing = BorrowingRequest::where('id', $requestId)
            ->where('user_id', Auth::id()) // Pastikan milik user yang login
            ->first();

        // 2. Validasi status
        if ($borrowing && $borrowing->status === 'Disetujui') {
            // 3. Ubah status jadi 'Dikembalikan'
            // (Admin nanti yang akan memverifikasi fisik barang di menu ReturnManager)
            $borrowing->update([
                'status' => 'Dikembalikan',
                'returned_at' => now(), // Opsional: jika ada kolom ini
            ]);

            session()->flash('message', 'Pengembalian diajukan. Silakan serahkan barang ke Admin untuk verifikasi.');
        } else {
            session()->flash('error', 'Gagal memproses pengembalian.');
        }
    }
}
