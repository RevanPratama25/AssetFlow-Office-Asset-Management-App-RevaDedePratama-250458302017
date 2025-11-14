<?php

namespace App\Livewire\Admin;

use Storage;
use App\Models\Asset;
use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads; // <-- Penting untuk upload file

#[Layout('components.admin-layout')]
class AssetManager extends Component
{
    use WithPagination;
    use WithFileUploads; // <-- Aktifkan trait upload file

    // Properti untuk form
    #[Rule('required|min:3|max:255')]
    public $name;

    #[Rule('required|max:50|unique:assets,asset_code')]
    public $asset_code;

    #[Rule('nullable|max:1000')]
    public $description;

    #[Rule('required|date')]
    public $purchase_date;

    #[Rule('required|numeric|min:0')]
    public $price;

    #[Rule('required|in:Tersedia,Dipakai,Rusak,Dalam Perbaikan')]
    public $status = 'Tersedia'; // Default status

    #[Rule('required|in:individu,bersama')]
    public $using_type = 'individu'; // Default tipe

    #[Rule('required|exists:categories,id')]
    public $category_id;

    #[Rule('nullable|exists:locations,id')]
    public $location_id;

    #[Rule('nullable|image|max:2048')] // Validasi file: gambar, maks 2MB
    public $photo;

    // Properti untuk Modal, Edit, dan List Dropdown
    public $isOpen = false;
    public $assetId;
    public $categories = [];
    public $locations = [];
    public $existingPhoto;

    /**
     * Metode mount() dipanggil saat komponen pertama kali di-load.
     * Kita gunakan untuk mengisi data dropdown.
     */
    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->locations = Location::orderBy('name')->get();
    }


    // Properti rules
    protected $rules = [
        'asset.name' => 'required|string|max:255',
        'asset.code' => 'required|string|unique:assets,code',
        'asset.category_id' => 'required|exists:categories,id',
    ];

    public $asset = [];

    public function save()
    {
        $this->validate(); // otomatis pakai $rules di atas
        // logika simpan data di sini
    }


    /**
     * Merender tampilan.
     */
    public function render()
    {
        // Ambil data aset dengan relasi (untuk performa) dan pagination
        $assets = Asset::with('category', 'location', 'currentUser')
                       ->latest()
                       ->paginate(10);
        
        return view('livewire.admin.asset-manager', [
            'assets' => $assets
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
        $asset = Asset::findOrFail($id);
        $this->assetId = $id;
        $this->name = $asset->name;
        $this->asset_code = $asset->asset_code;
        $this->description = $asset->description;
        $this->purchase_date = $asset->purchase_date;
        $this->price = $asset->price;
        $this->status = $asset->status;
        $this->using_type = $asset->using_type;
        $this->category_id = $asset->category_id;
        $this->location_id = $asset->location_id;
        $this->existingPhoto = $asset->photo_url; // Simpan path foto lama
        
        // Sesuaikan aturan validasi unik saat edit
        $this->rules['asset_code'] = 'required|max:50|unique:assets,asset_code,' . $id;

        $this->isOpen = true;
    }

    /**
     * Menyimpan data (baik baru atau update).
     */
    public function store()
    {
        // Validasi input
        $validatedData = $this->validate();

        // Logika upload file
        $photoPath = $this->existingPhoto; // Default pakai foto lama (jika edit)
        if ($this->photo) {
            // Hapus foto lama jika ada (saat edit & ganti foto)
            if ($this->existingPhoto) {
                Storage::disk('public')->delete($this->existingPhoto);
            }
            // Simpan foto baru
            $photoPath = $this->photo->store('asset-photos', 'public');
            $validatedData['photo_url'] = $photoPath;
        }

        // Hapus 'photo' dari data validasi karena sudah di-handle
        unset($validatedData['photo']);

        // Logika bersyarat untuk location_id (sesuai ERD)
        if ($validatedData['using_type'] === 'individu') {
            $validatedData['location_id'] = null;
        }

        // Logika Update-or-Create
        Asset::updateOrCreate(['id' => $this->assetId], $validatedData);

        // Kirim pesan sukses
        session()->flash('success', $this->assetId ? 'Aset berhasil diperbarui.' : 'Aset berhasil ditambahkan.');

        // Tutup modal
        $this->closeModal();
    }

    /**
     * Menghapus data aset.
     */
    public function delete($id)
    {
        $asset = Asset::find($id);
        
        // Hapus foto dari storage jika ada
        if ($asset->photo_url) {
            \Storage::disk('public')->delete($asset->photo_url);
        }

        $asset->delete();
        session()->flash('success', 'Aset berhasil dihapus.');
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
        $this->resetExcept('categories', 'locations'); // Jangan reset data dropdown
        $this->resetValidation();
        
        // Atur ulang aturan validasi unik ke default (untuk create)
        $this->rules['asset_code'] = 'required|max:50|unique:assets,asset_code';
    }
}