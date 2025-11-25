<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\BorrowingRequest;
use App\Models\Asset;
use Livewire\WithPagination;


class ReturnManager extends Component
{
    use WithPagination;

    // Aksi: Verifikasi Pengembalian
    public function verify($requestId)
    {
        $request = BorrowingRequest::find($requestId);

        if (!$request || $request->status !== 'Dikembalikan') {
            session()->flash('error', 'Data tidak valid atau status belum dikembalikan.');
            return;
        }

        // 1. Cari Aset terkait
        $asset = Asset::find($request->asset_id);

        // 2. Update Request jadi 'Selesai'
        
        $request->update([
            'status' => 'Selesai',
        ]);

        // 3. Update Aset jadi 'Tersedia' & Hapus peminjam
        if ($asset) {
            $asset->update([
                'status' => 'Tersedia',
                'current_user_id' => null // Kosongkan peminjam
            ]);
        }

        session()->flash('message', 'Pengembalian berhasil diverifikasi. Aset kini tersedia kembali.');
    }

    public function render()
    {
        // Ambil hanya yang statusnya 'Dikembalikan' (Menunggu verifikasi admin)
        $returns = BorrowingRequest::with(['user', 'asset'])

            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.return-manager', [
            'returns' => $returns
        ])->extends('components.admin-layout'); // Layout admin 
    }
}