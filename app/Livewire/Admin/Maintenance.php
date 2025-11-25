<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Asset;
use App\Models\MaintenanceLog;
use Illuminate\Support\Facades\Auth; // Jangan lupa ini
use Livewire\WithPagination;

class Maintenance extends Component
{
    use WithPagination;

    // Variabel Form
    public $asset_id, $problem_description;
    
    // Variabel Form Penyelesaian
    public $log_id_to_complete;
    public $action_taken, $cost;

    // Kontrol Modal
    public $isCreateModalOpen = false;
    public $isCompleteModalOpen = false;

    protected $rules = [
        'asset_id' => 'required|exists:assets,id',
        'problem_description' => 'required|min:5',
    ];

    // --- MODAL CREATION (LAPOR BARU) ---
    public function openCreateModal()
    {
        $this->reset(['asset_id', 'problem_description']);
        $this->isCreateModalOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateModalOpen = false;
    }

    public function store()
    {
        $this->validate();

        // 1. Simpan Log sesuai kolom Anda
        MaintenanceLog::create([
            'asset_id' => $this->asset_id,
            'problem_description' => $this->problem_description,
            'reported_by_user_id' => Auth::id(), // ID Admin/User yang lapor
            'reported_at' => now(),
            'status' => 'Dilaporkan', // Enum awal 
        ]);

        // 2. Update Status Aset
        $asset = Asset::find($this->asset_id);
        $asset->update(['status' => 'Dalam Perbaikan']);

        session()->flash('message', 'Aset berhasil masuk status Maintenance.');
        $this->closeCreateModal();
    }

    // --- MODAL COMPLETION (SELESAIKAN) ---
    public function openCompleteModal($id)
    {
        $this->log_id_to_complete = $id;
        $this->reset(['action_taken', 'cost']);
        $this->isCompleteModalOpen = true;
    }

    public function closeCompleteModal()
    {
        $this->isCompleteModalOpen = false;
    }

    public function updateAndComplete()
    {
        $this->validate([
            'action_taken' => 'required|min:3',
            'cost' => 'required|numeric|min:0',
        ]);

        $log = MaintenanceLog::find($this->log_id_to_complete);

        if ($log) {
            // 1. Update Log dengan Solusi & Biaya
            $log->update([
                'action_taken' => $this->action_taken,
                'cost' => $this->cost,
                'status' => 'Selesai', // Pastikan Enum ini ada di DB
                // Jika tidak ada kolom 'completion_date', kita pakai updated_at otomatis
            ]);

            // 2. Kembalikan Aset jadi Tersedia
            $asset = Asset::find($log->asset_id);
            if ($asset) {
                $asset->update(['status' => 'Tersedia']);
            }

            session()->flash('message', 'Perbaikan dicatat & Aset kembali tersedia.');
            $this->closeCompleteModal();
        }
    }

    public function render()
    {
        // Ambil maintenance yang statusnya BELUM Selesai
        // Sesuaikan string 'Selesai' dengan database Anda (case sensitive)
        $activeMaintenances = MaintenanceLog::with(['asset', 'reporter'])
            ->where('status', '!=', 'Selesai') 
            ->orderBy('reported_at', 'desc')
            ->paginate(10);

        // Ambil aset yang bisa diservis
        $availableAssets = Asset::whereIn('status', ['Tersedia', 'Rusak'])->get();

        return view('livewire.admin.maintenance', [
            'activeMaintenances' => $activeMaintenances,
            'availableAssets' => $availableAssets
        ])->extends('components.admin-layout');
    }
}