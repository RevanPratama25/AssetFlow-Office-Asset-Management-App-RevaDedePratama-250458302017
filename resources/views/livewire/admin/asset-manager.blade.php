<div>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Data Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    Tambah Aset Baru
                </button>

                @if (session()->has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($isOpen)
                    <div class="fixed inset-0 z-50 overflow-auto bg-gray-500 bg-opacity-75 flex">
                        <div class="relative p-8 bg-white w-full max-w-2xl m-auto flex-col flex rounded-lg">
                            <span wire:click="closeModal()" class="absolute top-0 right-0 p-4 cursor-pointer">&times;</span>
                            
                            <form wire:submit.prevent="store" enctype="multipart/form-data">
                                <h2 class="text-2xl font-bold mb-4">{{ $assetId ? 'Edit Aset' : 'Tambah Aset' }}</h2>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="mb-4">
                                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Aset:</label>
                                            <input type="text" id="name" wire:model.defer="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="asset_code" class="block text-gray-700 text-sm font-bold mb-2">Kode Aset:</label>
                                            <input type="text" id="asset_code" wire:model.defer="asset_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                            @error('asset_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="purchase_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Beli:</label>
                                            <input type="date" id="purchase_date" wire:model.defer="purchase_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                            @error('purchase_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Harga Beli (Rp):</label>
                                            <input type="number" step="0.01" id="price" wire:model.defer="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="mb-4">
                                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                                            <select id="category_id" wire:model.defer="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="using_type" class="block text-gray-700 text-sm font-bold mb-2">Tipe Penggunaan:</label>
                                            <select id="using_type" wire:model="using_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                                <option value="individu">Individu (Dipakai 1 Orang)</option>
                                                <option value="bersama">Bersama (Inventaris Ruangan)</option>
                                            </select>
                                            @error('using_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>

                                        @if($using_type == 'bersama')
                                        <div class="mb-4 transition-all">
                                            <label for="location_id" class="block text-gray-700 text-sm font-bold mb-2">Lokasi:</label>
                                            <select id="location_id" wire:model.defer="location_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                                <option value="">-- Pilih Lokasi --</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('location_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        @endif

                                        <div class="mb-4">
                                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status Awal:</label>
                                            <select id="status" wire:model.defer="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                                <option value="Tersedia">Tersedia</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                                <option value="Dipakai" disabled>Dipakai (Otomatis)</option>
                                            </select>
                                            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional):</label>
                                    <textarea id="description" wire:model.defer="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">Foto Aset (Opsional, Maks 2MB):</label>
                                    <input type="file" id="photo" wire:model="photo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                    @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    
                                    <div class="mt-2">
                                        @if ($photo)
                                            <span class="block text-sm text-gray-500">Preview foto baru:</span>
                                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded">
                                        @elseif ($existingPhoto)
                                            <span class="block text-sm text-gray-500">Foto saat ini:</span>
                                            <img src="{{ asset('storage/' . $existingPhoto) }}" alt="Foto Aset" class="w-32 h-32 object-cover rounded">
                                        @endif
                                    </div>
                                    <div wire:loading wire:target="photo" class="text-sm text-gray-500">Mengupload...</div>
                                </div>
                                
                                <div class="flex items-center justify-end">
                                    <button type="button" wire:click="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                        Batal
                                    </button>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi/Pemakai</th>
                                <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($assets as $asset)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($asset->photo_url)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $asset->photo_url) }}" alt="{{ $asset->name }}">
                                                @else
                                                    <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">?</span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $asset->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ $asset->asset_code }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ $asset->category->name ?? 'N/A' }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-500">{{ $asset->using_type }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($asset->status == 'Tersedia') bg-green-100 text-green-800 
                                            @elseif($asset->status == 'Dipakai') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $asset->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            @if($asset->using_type == 'bersama')
                                                {{ $asset->location->name ?? 'N/A' }}
                                            @else
                                                {{ $asset->currentUser->name ?? '-' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="edit({{ $asset->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button wire:click="delete({{ $asset->id }})" 
                                                wire:confirm="Anda yakin ingin menghapus aset ini? Tindakan ini tidak bisa dibatalkan."
                                                class="text-red-600 hover:text-red-900 ml-4">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Belum ada data aset.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $assets->links() }}
                </div>

            </div>
        </div>
    </div>
</div>