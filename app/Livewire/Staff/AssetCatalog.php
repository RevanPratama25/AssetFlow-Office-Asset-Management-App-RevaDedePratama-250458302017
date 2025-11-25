<?php

namespace App\Livewire\Staff;

use App\Models\Asset;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BorrowingRequest;
use Illuminate\Support\Facades\Auth;

class AssetCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $category_id = ''; // Untuk filter kategori nanti
    public $isModalOpen = false;
    public $selectedAsset = null;
    public $start_date;
    public $end_date;
    public $notes;

    protected $rules = [
        'start_date' => 'required|date|after_or_equal:today',
        'end_date'   => 'required|date|after_or_equal:start_date',
        'notes'      => 'required|string|max:500',
    ];

    // Fungsi Debugging & Buka Modal
    public function openBorrowModal($assetId)
    {
        // 1. Cari Aset
        $this->selectedAsset = Asset::find($assetId);

        // 2. Cek Jika Aset Tidak Ditemukan (Mencegah Error 500)
        if (!$this->selectedAsset) {
            session()->flash('error', 'Aset tidak ditemukan atau telah dihapus.');
            return;
        }

        // 3. Reset Form & Buka Modal
        $this->reset(['start_date', 'end_date', 'notes']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->selectedAsset = null;
    }

    public function submitRequest()
    {
        $this->validate();

        // Pastikan aset masih ada saat submit
        if (!$this->selectedAsset) {
            return;
        }

        BorrowingRequest::create([
            'user_id'    => Auth::id(),
            'asset_id'   => $this->selectedAsset->id,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'notes'      => $this->notes,
            'status'     => 'Pending',
        ]);

        session()->flash('message', 'Pengajuan berhasil dikirim!');
        $this->closeModal();
    }

    public function render()
    {
        // Query Dasar: Aset Tersedia & Tipe Individual
        $query = Asset::where('status', 'Tersedia')
                      ->where('using_type', 'individu'); // Samakan enum di DB 'individu' 

        // Filter Pencarian
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Filter Kategori (Opsional, jika ingin menambahkan dropdown kategori)
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        $assets = $query->orderBy('created_at', 'desc')->paginate(12); // Tampilkan 12 per halaman (Grid)

        return view('livewire.staff.asset-catalog', [
            'assets' => $assets
        ])->extends('components.staff-layout'); // Layout staf 
    }
}