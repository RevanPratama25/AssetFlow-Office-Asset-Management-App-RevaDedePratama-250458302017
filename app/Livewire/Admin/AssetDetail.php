<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Asset;
use Livewire\WithPagination;

class AssetDetail extends Component
{
    use WithPagination;

    public $asset_id;
    public $activeTab = 'info'; // Tabs: info, borrowings, maintenance

    public function mount($id)
    {
        $this->asset_id = $id;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $asset = Asset::findOrFail($this->asset_id);

        // Ambil riwayat peminjaman (Pagination terpisah jika data banyak)
        $borrowings = $asset->borrowingRequests()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'borrowingsPage');

        // Ambil riwayat maintenance
        $maintenances = $asset->maintenanceLogs()
            ->with('reporter') // Pastikan relasi 'reporter' ada di MaintenanceLog
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'maintenancePage');

        return view('livewire.admin.asset-detail', [
            'asset' => $asset,
            'borrowings' => $borrowings,
            'maintenances' => $maintenances
        ])->layout('components.admin-layout', ['title' => 'Detail Aset']);
    }
}