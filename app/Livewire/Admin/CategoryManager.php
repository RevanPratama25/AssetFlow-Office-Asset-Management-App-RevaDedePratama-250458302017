<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category; // <-- Import Model Category
use Livewire\Attributes\Layout; // <-- Import Layout attribute
use Livewire\Attributes\Rule; // <-- Import Rule attribute
use Livewire\WithPagination; // <-- Import pagination

#[Layout('components.admin-layout')] // <-- Menentukan layout utama
class CategoryManager extends Component
{
    use WithPagination; // <-- Mengaktifkan pagination

    // Properti untuk form (Create/Update)
    #[Rule('required|min:3|max:255')]
    public $name;

    #[Rule('nullable|max:500')]
    public $description;
    
    // Properti untuk Modal & Edit
    public $isOpen = false;
    public $categoryId;

    /**
     * Merender tampilan.
     * Metode ini dipanggil oleh Livewire untuk menampilkan komponen.
     */
    public function render()
    {
        // Ambil semua data kategori dengan pagination
        $categories = Category::latest()->paginate(10);
        
        // Kirim data ke view
        return view('livewire.admin.category-manager', [
            'categories' => $categories
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
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        
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
        Category::updateOrCreate(
            ['id' => $this->categoryId], // Cari berdasarkan ID
            [
                'name' => $this->name, // Data untuk di-update atau dibuat
                'description' => $this->description
            ]
        );

        // Kirim pesan sukses
        session()->flash('success', $this->categoryId ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.');

        // Tutup modal
        $this->closeModal();
    }

    /**
     * Menghapus data kategori.
     */
    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('success', 'Kategori berhasil dihapus.');
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
        // $this->reset() adalah bawaan Livewire
        $this->reset(['name', 'description', 'categoryId']);
    }
}