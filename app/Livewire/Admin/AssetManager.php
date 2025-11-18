<?php

namespace App\Livewire\Admin;

use App\Models\Asset;
use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Str;

use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Storage;

#[Layout('components.admin-layout')]
class AssetManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url(keep: true)] // 'keep' berarti tidak akan di-reset saat pindah komponen
    public $search = '';

    #[Url(keep: true)]
    public $filterCategory = '';

    #[Url(keep: true)]
    public $filterLocation = '';

    #[Url(keep: true)]
    public $filterType = '';
    // Properti untuk form (tanpa atribut #[Rule])
    public $name;
    // asset_code dihapus, akan di-generate otomatis
    public $description;
    public $purchase_date;
    public $price;
    public $status = 'Tersedia';
    public $using_type = 'individu';
    public $category_id;
    public $location_id;
    public $photo;

    // Properti untuk Modal, Edit, dan List Dropdown
    public $isOpen = false;
    public $assetId;
    public $categories = [];
    public $locations = [];
    public $existingPhoto;

    /**
     * [BARU] Metode rules() untuk validasi yang lebih kompleks
     */
    protected function rules()
    {
        // Aturan dasar
        $rules = [
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'purchase_date' => 'required|date',
            'price' => 'required|numeric|min:0', // Akan divalidasi setelah dibersihkan
            'status' => 'required|in:Tersedia,Dipakai,Rusak,Dalam Perbaikan',
            'using_type' => 'required|in:individu,bersama',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|max:2048',
        ];

        // Aturan bersyarat untuk location_id
        if ($this->using_type === 'bersama') {
            // JIKA 'bersama', LOKASI WAJIB DIISI
            $rules['location_id'] = 'required|exists:locations,id';
        } else {
            // JIKA 'individu', LOKASI HARUS NULL (opsional)
            $rules['location_id'] = 'nullable';
        }

        return $rules;
    }

    // Hook ini akan dijalankan SETIAP KALI properti 'search' diperbarui
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination ke halaman 1
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterLocation()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    /**
     * Metode mount() dipanggil saat komponen pertama kali di-load.
     */
    public function mount()
    {
        $this->categories = Category::orderBy('name')->get();
        $this->locations = Location::orderBy('name')->get();
    }

    /**
     * Merender tampilan.
     */
    public function render()
    {
        // [MODIFIKASI] Mulai kueri dinamis
        $query = Asset::query()
            ->with('category', 'location', 'currentUser'); // Eager load relasi

        // Filter PENCARIAN NAMA
        $query->when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
        });

        // Filter KATEGORI
        $query->when($this->filterCategory, function ($q) {
            $q->where('category_id', $this->filterCategory);
        });

        // Filter LOKASI
        $query->when($this->filterLocation, function ($q) {
            $q->where('location_id', $this->filterLocation);
        });

        // Filter TIPE PENGGUNAAN
        $query->when($this->filterType, function ($q) {
            $q->where('using_type', $this->filterType);
        });

        // Ambil hasil akhir dengan pagination
        $assets = $query->latest()->paginate(10);
        
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
        // $this->asset_code tidak perlu di-edit
        $this->description = $asset->description;
        $this->purchase_date = $asset->purchase_date;
        $this->price = $asset->price; // Harga dikirim sebagai angka
        $this->status = $asset->status;
        $this->using_type = $asset->using_type;
        $this->category_id = $asset->category_id;
        $this->location_id = $asset->location_id;
        $this->existingPhoto = $asset->photo_url;
        
        $this->isOpen = true;
    }

    /**
     * Menyimpan data (baik baru atau update).
     */
    public function store()
    {
        // [MODIFIKASI] 
        // Bersihkan input harga SEBELUM validasi
        // Ini mengubah "1.800.000" menjadi "1800000"
        if ($this->price) {
            $this->price = preg_replace('/[^\d]/', '', $this->price);
        }

        // Validasi input menggunakan metode rules()
        $validatedData = $this->validate();

        // Logika upload file
        $photoPath = $this->existingPhoto;
        if ($this->photo) {
            if ($this->existingPhoto) {
                Storage::disk('public')->delete($this->existingPhoto);
            }
            $photoPath = $this->photo->store('asset-photos', 'public');
            $validatedData['photo_url'] = $photoPath;
        }
        unset($validatedData['photo']);

        // Logika bersyarat untuk location_id
        if ($validatedData['using_type'] === 'individu') {
            $validatedData['location_id'] = null;
        }

        // Generate asset_code HANYA jika ini adalah data baru
        if (!$this->assetId) {
            $validatedData['asset_code'] = 'AST-' . time();
        }

        // Logika Update-or-Create
        Asset::updateOrCreate(['id' => $this->assetId], $validatedData);

        session()->flash('success', $this->assetId ? 'Aset berhasil diperbarui.' : 'Aset berhasil ditambahkan.');
        $this->closeModal();
    }

    /**
     * Menghapus data aset.
     */
    public function delete($id)
    {
        $asset = Asset::find($id);
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
        $this->resetExcept('categories', 'locations');
        $this->resetValidation();
    }
}