<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section (Hanya Judul) --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Manajemen Data Aset</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Inventarisasi dan pelacakan status aset perusahaan.</p>
    </div>

    {{-- Alert Messages --}}
    @if (session()->has('success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-6 rounded-r-lg shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    

    
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
        {{-- Filter & Action Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-5 mb-0 ">
            
            {{-- Baris 1: Search & Button Tambah --}}
            <div class="flex flex-col md:flex-row gap-4 mb-4">
                {{-- Search Input (Mengisi sisa ruang / flex-1) --}}
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari berdasarkan nama aset, kode, atau deskripsi..."
                        class="pl-10 block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm py-2.5 shadow-sm">
                </div>

                {{-- Tombol Tambah (Dipindahkan ke sini) --}}
                <button wire:click="create" class="flex-none flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-medium py-2.5 px-5 rounded-lg shadow-md shadow-blue-500/20 transition-all transform hover:-translate-y-0.5 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Aset
                </button>
            </div>

            {{-- Baris 2: Filter Dropdowns --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                <select wire:model.live="filterCategory"
                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm py-2.5 shadow-sm cursor-pointer">
                    <option value=""> Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filterLocation"
                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm py-2.5 shadow-sm cursor-pointer">
                    <option value=""> Semua Lokasi</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filterType"
                    class="block w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition-all duration-200 text-sm py-2.5 shadow-sm cursor-pointer">
                    <option value=""> Semua Tipe</option>
                    <option value="individu">Individu</option>
                    <option value="bersama">Bersama</option>
                </select>
            </div>
        </div>  

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Lokasi/Pemakai</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($assets as $asset)
                        <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if ($asset->photo_url)
                                            <img class="h-10 w-10 rounded-lg object-cover border border-slate-200 dark:border-slate-600"
                                                src="{{ asset('storage/' . $asset->photo_url) }}"
                                                alt="{{ $asset->name }}">
                                        @else
                                            <span class="h-10 w-10 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $asset->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 dark:text-slate-300 font-mono bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded inline-block">
                                    {{ $asset->asset_code }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 dark:text-slate-400">{{ $asset->category->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-600 dark:text-slate-400 capitalize">{{ $asset->using_type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border
                                    @if ($asset->status == 'Tersedia') bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/50 dark:text-emerald-300 dark:border-emerald-800
                                    @elseif($asset->status == 'Dipakai') bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/50 dark:text-amber-300 dark:border-amber-800
                                    @else bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-900/50 dark:text-rose-300 dark:border-rose-800 @endif">
                                    {{ $asset->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                    @if ($asset->using_type == 'bersama')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $asset->location->name ?? 'N/A' }}
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $asset->currentUser->name ?? '-' }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <button wire:click="edit({{ $asset->id }})" class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $asset->id }})" 
                                    wire:confirm="Anda yakin ingin menghapus aset ini? Tindakan ini tidak bisa dibatalkan."
                                    class="text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                    <svg class="h-12 w-12 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <span class="text-base font-medium">Belum ada data aset yang tersedia.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($assets->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                {{ $assets->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Form --}}
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-slate-900/75 backdrop-blur-sm flex transition-opacity duration-300">
            <div class="relative p-0 bg-white dark:bg-slate-800 w-full max-w-2xl m-auto flex-col flex rounded-xl shadow-2xl border border-slate-200 dark:border-slate-700">
                
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50 rounded-t-xl">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        {{ $assetId ? 'Edit Data Aset' : 'Tambah Aset Baru' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 overflow-y-auto max-h-[80vh]">
                    <form wire:submit.prevent="store" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Kolom Kiri --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Aset</label>
                                    <input type="text" wire:model.defer="name" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400">
                                    @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Beli</label>
                                    <input type="date" wire:model.defer="purchase_date" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition [color-scheme:light] dark:[color-scheme:dark]">
                                    @error('purchase_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Alpine JS Currency Formatter --}}
                                <div x-data="{
                                    rawPrice: @entangle('price'),
                                    formatRupiah(number) {
                                        if (!number) return '';
                                        let clean = number.toString().replace(/[^0-9]/g, '');
                                        if (clean === '') return '';
                                        return parseInt(clean, 10).toLocaleString('id-ID');
                                    },
                                    updateValue(event) {
                                        let clean = event.target.value.replace(/[^0-9]/g, '');
                                        this.rawPrice = clean === '' ? null : clean;
                                        this.$nextTick(() => { event.target.value = this.formatRupiah(this.rawPrice); });
                                    }
                                }" x-init="$refs.priceInput.value = formatRupiah(rawPrice)">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Harga Beli (Rp)</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 text-sm">Rp</span>
                                        <input type="text" x-ref="priceInput" x-on:input.debounce.150ms="updateValue($event)" placeholder="0"
                                            class="pl-10 w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400">
                                    </div>
                                    @error('price') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                                    <select wire:model.defer="category_id" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tipe Penggunaan</label>
                                    <select wire:model="using_type" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition">
                                        <option value="individu">Individu (Dipakai atau Diwakilkan 1 Orang)</option>
                                        <option value="bersama">Bersama (Inventaris Ruangan)</option>
                                    </select>
                                    @error('using_type') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                @if ($using_type == 'bersama')
                                    <div class="animate-fade-in-down">
                                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Lokasi</label>
                                        <select wire:model.defer="location_id" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition">
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('location_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status Awal</label>
                                    <select wire:model.defer="status" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                        <option value="Dipakai" disabled>Dipakai (Otomatis)</option>
                                    </select>
                                    @error('status') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi</label>
                            <textarea wire:model.defer="description" rows="3" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400"></textarea>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Foto Aset</label>
                            <input type="file" wire:model="photo" class="block w-full text-sm text-slate-500 dark:text-slate-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 dark:file:bg-blue-900/30
                                file:text-blue-700 dark:file:text-blue-300
                                hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50
                                cursor-pointer transition">
                            @error('photo') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            
                            <div wire:loading wire:target="photo" class="text-xs text-blue-500 mt-1 flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengupload...
                            </div>

                            @if ($photo || $existingPhoto)
                                <div class="mt-3">
                                    <p class="text-xs text-slate-500 mb-1">Preview:</p>
                                    <img src="{{ $photo ? $photo->temporaryUrl() : asset('storage/' . $existingPhoto) }}" 
                                        class="w-32 h-32 object-cover rounded-lg border border-slate-200 dark:border-slate-600 shadow-sm">
                                </div>
                            @endif
                        </div>

                        {{-- Modal Footer --}}
                        <div class="mt-8 flex items-center justify-end space-x-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <button type="button" wire:click="closeModal()" class="bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-600 font-medium transition-all duration-200">
                                Batal
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md shadow-blue-500/20 font-medium transition-all duration-200 transform active:scale-95">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>