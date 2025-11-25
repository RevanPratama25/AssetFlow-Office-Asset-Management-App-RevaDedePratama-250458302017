<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Location; // <-- Diubah
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

#[Layout('components.admin-layout')]
class LocationManager extends Component // <-- Diubah
{
    use WithPagination;

    // Properti untuk form
    #[Rule('required|min:3|max:255')]
    public $name;

    #[Rule('nullable|max:500')]
    public $description;
    
    // Properti untuk Modal & Edit
    public $isOpen = false;
    public $locationId; // <-- Diubah

    /**
     * Merender tampilan.
     */
    public function render()
    {
        // Ambil data lokasi dengan pagination
        $locations = Location::latest()->paginate(10); 
        
        // Kirim data ke view
        return view('livewire.admin.location-manager', [ 
            'locations' => $locations 
        ]);
    }

    /**
     * Membuka modal untuk membuat data baru.
     */
    public function create()
    {
        $this->resetInputs();
        $this->isOpen = true;
    }

    /**
     * Membuka modal untuk mengedit data.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id); // <-- Diubah
        $this->locationId = $id; // <-- Diubah
        $this->name = $location->name;
        $this->description = $location->description;
        
        $this->isOpen = true;
    }

    /**
     * Menyimpan data (baik baru atau update).
     */
    public function store()
    {
        // Validasi input
        $this->validate();

        // Logika Update-or-Create
        Location::updateOrCreate( // <-- Diubah
            ['id' => $this->locationId], // <-- Diubah
            [
                'name' => $this->name,
                'description' => $this->description
            ]
        );

        // Kirim pesan sukses
        session()->flash('success', $this->locationId ? 'Lokasi berhasil diperbarui.' : 'Lokasi berhasil ditambahkan.'); // <-- Diubah

        // Tutup modal
        $this->closeModal();
    }

    /**
     * Menghapus data lokasi.
     */
    public function delete($id)
    {
        Location::find($id)->delete(); // <-- Diubah
        session()->flash('success', 'Lokasi berhasil dihapus.'); // <-- Diubah
    }

    /**
     * Menutup modal.
     */
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputs();
    }

    /**
     * Helper untuk mereset field input.
     */
    private function resetInputs()
    {
        $this->reset(['name', 'description', 'locationId']); // <-- Diubah
    }
}