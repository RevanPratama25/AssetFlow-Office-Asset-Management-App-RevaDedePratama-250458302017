<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Asset;
use App\Models\MaintenanceLog;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads; 
use function Symfony\Component\Clock\now;// Wajib untuk upload foto

class ReportDamage extends Component
{
    use WithFileUploads;

    // Form States
    public $search = '';
    public $selectedAsset = null;
    public $description;
    public $photo; // Jika ingin fitur upload bukti foto (opsional)

    // Logika Pencarian Aset
    public function selectAsset($id)
    {
        $this->selectedAsset = Asset::find($id);
        $this->search = ''; // Reset pencarian setelah memilih
    }

    public function resetSelection()
    {
        $this->selectedAsset = null;
        $this->reset(['description', 'photo']);
    }

    public function submitReport()
    {
        $this->validate([
            'selectedAsset' => 'required',
            'description'   => 'required|string|min:10',
            'photo'         => 'nullable|image|max:2048',
        ]);

        // 1. Simpan Laporan
        MaintenanceLog::create([
            'asset_id'            => $this->selectedAsset->id,
            'reported_by_user_id' => Auth::id(),
            'problem_description' => $this->description,
            'status'              => 'Dilaporkan',
            'reported_at'         => now(), 
        ]);

        // 2. Ubah Status Aset Jadi 'Rusak'
        $this->selectedAsset->update([
            'status' => 'Rusak'
        ]);

        session()->flash('message', 'Laporan kerusakan berhasil dikirim. Terima kasih atas laporannya.');
        $this->resetSelection();
    }

    public function render()
    {
        $results = [];
        
        // Cari aset hanya jika user mengetik sesuatu
        if (strlen($this->search) >= 2) {
            $results = Asset::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('asset_code', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
        }

        return view('livewire.staff.report-damage', [
            'results' => $results
        ])->extends('components.staff-layout')->section('content');
    }
}