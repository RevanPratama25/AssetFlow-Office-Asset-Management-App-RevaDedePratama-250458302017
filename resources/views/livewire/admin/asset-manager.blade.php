<div>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Data Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 transition-colors duration-300">

                {{-- Tombol Tambah --}}
                <button wire:click="create()"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg mb-4 transition-colors duration-150 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Tambah Aset Baru
                </button>

                {{-- ▼▼▼ BLOK FILTER (Layout & Styling Baru) ▼▼▼ --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"> {{-- Diubah ke 3 kolom & margin bottom ditambah --}}
                    
                    {{-- Baris Pertama: Search (dibuat jadi 3 kolom penuh) --}}
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari berdasarkan nama aset, kode..."
                        class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md 
                            dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 
                            focus:ring-blue-500 focus:border-blue-500 
                            md:col-span-3"> {{-- <-- KUNCI PERUBAHAN LAYOUT --}}

                    {{-- Baris Kedua: 3 Filter (otomatis mengisi 3 kolom) --}}
                    <select wire:model.live="filterCategory"
                        class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md 
                            dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                            focus:ring-blue-500 focus:border-blue-500">
                        <option value=""> Semua Kategori </option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    
                    <select wire:model.live="filterLocation"
                        class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md 
                            dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                            focus:ring-blue-500 focus:border-blue-500">
                        <option value=""> Semua Lokasi </option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                    
                    <select wire:model.live="filterType"
                        class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md 
                            dark:bg-gray-700 dark:border-gray-600 dark:text-white 
                            focus:ring-blue-500 focus:border-blue-500">
                        <option value=""> Semua Tipe </option>
                        <option value="individu">Individu</option>
                        <option value="bersama">Bersama</option>
                    </select>
                </div>
                {{-- ▲▲▲ AKHIR DARI BLOK FILTER ▲▲▲ --}}

                {{-- Alert Sukses --}}
                @if (session()->has('success'))
                    <div class="bg-green-100 dark:bg-green-900/50 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-4 mb-4 rounded-r-lg"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Modal Form (Struktur Asli Anda, dengan Styling) --}}
                @if ($isOpen)
                                <div
                                    class="fixed inset-0 z-50 overflow-auto bg-gray-900/75 backdrop-blur-sm flex transition-opacity duration-300">
                                    <div
                                        class="relative p-8 bg-white dark:bg-gray-800 w-full max-w-2xl m-auto flex-col flex rounded-lg shadow-2xl">

                                        {{-- Tombol Tutup (X) yang Rapi --}}
                                        <button wire:click="closeModal()"
                                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors duration-150 focus:outline-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>

                                        <form wire:submit.prevent="store" enctype="multipart/form-data">
                                            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">
                                                {{ $assetId ? 'Edit Aset' : 'Tambah Aset' }}</h2>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                {{-- Kolom Kiri --}}
                                                <div>
                                                    <div class="mb-4">
                                                        <label for="name"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                                            Aset:</label>
                                                        <input type="text" id="name" wire:model.defer="name"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500">
                                                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="purchase_date"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal
                                                            Beli:</label>
                                                        <input type="date" id="purchase_date" wire:model.defer="purchase_date"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                                            style="color-scheme: dark;">
                                                        @error('purchase_date') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div x-data="{
                                                            // 1. Sinkronkan 'rawPrice' dengan properti $price di Livewire
                                                            rawPrice: @entangle('price'), 

                                                            // 2. Fungsi untuk memformat angka ke Rupiah (id-ID)
                                                            formatRupiah(number) {
                                                                if (number === null || number === undefined || number === '') return '';
                                                                // Bersihkan dari non-angka
                                                                let clean = number.toString().replace(/[^0-9]/g, '');
                                                                if (clean === '') return '';
                                                                // Format ke 'id-ID' (misal: 1.800.000)
                                                                return parseInt(clean, 10).toLocaleString('id-ID');
                                                            },

                                                            // 3. Fungsi yang dipanggil saat user mengetik
                                                            updateValue(event) {
                                                                // Ambil nilai dari input, bersihkan (hanya angka)
                                                                let clean = event.target.value.replace(/[^0-9]/g, '');

                                                                // Update properti 'rawPrice' (yang akan dikirim ke Livewire)
                                                                this.rawPrice = clean === '' ? null : clean;

                                                                // Update nilai di input yang TERLIHAT agar terformat
                                                                // $nextTick menunggu Livewire selesai update sebelum kita format ulang
                                                                // Ini penting agar kursor tidak meloncat-loncat
                                                                this.$nextTick(() => {
                                                                    event.target.value = this.formatRupiah(this.rawPrice);
                                                                });
                                                            }
                                                        }" x-init="
                                                            // 4. Saat Alpine dimuat, format nilai awal yang mungkin ada (saat mode edit)
                                                            $refs.priceInput.value = formatRupiah(rawPrice);
                                                        ">
                                                        <label for="formatted_price"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga Beli (Rp):</label>

                                                        <input type="text" id="formatted_price" x-ref="priceInput" {{-- Referensi untuk
                                                            x-init --}} x-on:input.debounce.150ms="updateValue($event)" {{-- Panggil
                                                            fungsi update --}} placeholder="Input harga beli"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500">

                                                        {{-- Input ini tidak terlihat, tapi nilainya (angka bersih) yang dikirim ke
                                                        Livewire --}}
                                                        {{-- Kita sudah menggunakan @entangle, jadi input hidden tidak diperlukan --}}

                                                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Kolom Kanan --}}
                                                <div>
                                                    <div class="mb-4">
                                                        <label for="category_id"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori:</label>
                                                        <select id="category_id" wire:model.defer="category_id"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                                            <option value="">-- Pilih Kategori --</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="using_type"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe
                                                            Penggunaan:</label>
                                                        <select id="using_type" wire:model="using_type"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                                            <option value="individu">Individu (Dipakai 1 Orang)</option>
                                                            <option value="bersama">Bersama (Inventaris Ruangan)</option>
                                                        </select>
                                                        @error('using_type') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    @if ($using_type == 'bersama')
                                                        <div class="mb-4 transition-all duration-300">
                                                            <label for="location_id"
                                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi:</label>
                                                            <select id="location_id" wire:model.defer="location_id"
                                                                class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                                                <option value="">-- Pilih Lokasi --</option>
                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('location_id') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif

                                                    <div class="mb-4">
                                                        <label for="status"
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status
                                                            Awal:</label>
                                                        <select id="status" wire:model.defer="status"
                                                            class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                                            <option value="Tersedia">Tersedia</option>
                                                            <option value="Rusak">Rusak</option>
                                                            <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                                            <option value="Dipakai" disabled>Dipakai (Otomatis)</option>
                                                        </select>
                                                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="description"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi
                                                    (Opsional):</label>
                                                <textarea id="description" wire:model.defer="description" rows="3"
                                                    class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                            </div>

                                            <div class="mb-4">
                                                <label for="photo"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Aset
                                                    (Opsional, Maks 2MB):</label>
                                                <input type="file" id="photo" wire:model="photo" class="block w-full text-sm text-gray-700 dark:text-gray-300
                                                            file:mr-4 file:py-2 file:px-4
                                                            file:rounded-full file:border-0
                                                            file:text-sm file:font-semibold
                                                            file:bg-blue-50 dark:file:bg-blue-900/50
                                                            file:text-blue-700 dark:file:text-blue-300
                                                            hover:file:bg-blue-100 hover:roun 
                                                            dark:hover:file:bg-blue-900
                                                            transition-colors duration-150 cursor-pointer">
                                                @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                                                <div wire:loading wire:target="photo"
                                                    class="text-sm text-blue-600 dark:text-blue-400 mt-2">Mengupload...</div>

                                                <div class="mt-2">
                                                    @if ($photo)
                                                        <span class="block text-sm text-gray-500 dark:text-gray-400">Preview foto
                                                            baru:</span>
                                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview"
                                                            class="w-32 h-32 object-cover rounded-lg border dark:border-gray-600 mt-1">
                                                    @elseif ($existingPhoto)
                                                        <span class="block text-sm text-gray-500 dark:text-gray-400">Foto saat ini:</span>
                                                        <img src="{{ asset('storage/' . $existingPhoto) }}" alt="Foto Aset"
                                                            class="w-32 h-32 object-cover rounded-lg border dark:border-gray-600 mt-1">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-end pt-6 border-t dark:border-gray-700">
                                                <button type="button" wire:click="closeModal()"
                                                    class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 sm:w-auto sm:text-sm transition-colors duration-150 mr-2">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 sm:w-auto sm:text-sm transition-colors duration-150">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                @endif

                {{-- Kontainer Tabel --}}
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aset</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kode</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kategori</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Lokasi/Pemakai</th>
                                    <th class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($assets as $asset)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if ($asset->photo_url)
                                                        <img class="h-10 w-10 rounded-full object-cover"
                                                            src="{{ asset('storage/' . $asset->photo_url) }}"
                                                            alt="{{ $asset->name }}">
                                                    @else
                                                        <span
                                                            class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $asset->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400 font-mono">
                                                {{ $asset->asset_code }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $asset->category->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                                                {{ $asset->using_type }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if ($asset->status == 'Tersedia') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300
                                                    @elseif($asset->status == 'Dipakai') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300
                                                    @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @endif">
                                                {{ $asset->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                @if ($asset->using_type == 'bersama')
                                                    {{ $asset->location->name ?? 'N/A' }}
                                                @else
                                                    {{ $asset->currentUser->name ?? '-' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="edit({{ $asset->id }})"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">Edit</button>
                                            <button wire:click="delete({{ $asset->id }})"
                                                wire:confirm="Anda yakin ingin menghapus aset ini? Tindakan ini tidak bisa dibatalkan."
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 ml-4 transition-colors duration-150">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-10 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-10 w-10 text-gray-300 dark:text-gray-600 mb-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p>Belum ada data aset yang tersedia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $assets->links() }}
                </div>

            </div>
        </div>
    </div>
</div>