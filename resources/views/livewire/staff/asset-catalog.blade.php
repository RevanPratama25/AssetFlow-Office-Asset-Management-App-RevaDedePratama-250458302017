<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header & Search Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Katalog Aset</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-base">
                Pilih aset yang tersedia untuk menunjang produktivitas pekerjaan Anda.
            </p>
        </div>
        
        {{-- Search Bar "Floating" --}}
        <div class="relative w-full md:w-80">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live="search" placeholder="Cari aset..." 
                class="w-full pl-11 pr-4 py-3 rounded-xl border-none bg-white dark:bg-slate-800 text-slate-800 dark:text-white shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 ring-1 ring-slate-200 dark:ring-slate-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200 placeholder-slate-400">
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-8 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-rose-50 dark:bg-rose-900/30 border-l-4 border-rose-500 text-rose-700 dark:text-rose-400 p-4 mb-8 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Grid Aset --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($assets as $asset)
            <div class="group bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden relative">

                {{-- Image Section --}}
                <div
                    class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden group-hover:opacity-90 transition">
                    @if($asset->photo_url)
                        {{-- Tampilkan Gambar Asli --}}
                        <img src="{{ asset('storage/' . $asset->photo_url) }}" alt="{{ $asset->name }}" class="w-full h-full object-cover">
                    @else
                        {{-- Placeholder Icon (Jika tidak ada gambar) --}}
                        <div class="flex flex-col items-center text-gray-300">
                            <svg class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs font-medium">No Image</span>
                        </div>
                    @endif

                    {{-- Badge Status (Overlay) --}}
                    <div class="absolute top-2 right-2">
                        <span
                            class="bg-white/90 backdrop-blur text-green-700 text-xs font-bold px-2 py-1 rounded-full shadow-sm border border-green-100">
                            {{ $asset->status }}
                        </span>
                    </div>
                </div>

                {{-- Content Section --}}
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold tracking-wider text-blue-600 dark:text-blue-400 uppercase">
                                {{ $asset->category->name ?? 'UMUM' }}
                            </span>
                            <span class="text-xs font-mono text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded">
                                {{ $asset->asset_code }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 dark:text-white leading-tight mb-2 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $asset->name }}
                        </h3>
                    </div>

                    {{-- Tombol Pinjam --}}
                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <button wire:click="openBorrowModal({{ $asset->id }})" class="w-full bg-slate-900 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-500 font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-slate-900/20 dark:shadow-blue-600/30 transition-all duration-300 flex items-center justify-center gap-2 group/btn">
                            <span>Pinjam Aset</span>
                            <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 border-dashed">
                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-full p-6 mb-4">
                    <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Tidak ada aset tersedia</h3>
                <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto">Saat ini belum ada aset yang sesuai dengan kriteria pencarian Anda.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-10">
        {{ $assets->links() }}
    </div>

    {{-- MODAL FORM STYLE BARU --}}
    @if($isModalOpen && $selectedAsset)
        <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            {{-- Backdrop Blur & Dark Overlay --}}
            <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                
                {{-- Modal Panel --}}
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg w-full border border-slate-200 dark:border-slate-700">
                    
                    {{-- Modal Header --}}
                    <div class="bg-slate-50/50 dark:bg-slate-800/50 px-6 py-5 border-b border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-lg text-blue-600 dark:text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg leading-6 font-bold text-slate-800 dark:text-white">
                                    Form Peminjaman
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                    Aset: <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $selectedAsset->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Form Content --}}
                    <div class="px-6 py-6 space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Mulai</label>
                                <input type="date" wire:model="start_date" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition [color-scheme:light] dark:[color-scheme:dark]">
                                @error('start_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal Kembali</label>
                                <input type="date" wire:model="end_date" class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition [color-scheme:light] dark:[color-scheme:dark]">
                                @error('end_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Keperluan Peminjaman</label>
                            <textarea wire:model="notes" rows="3" placeholder="Jelaskan alasan peminjaman..." class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400"></textarea>
                            @error('notes') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-100 dark:border-slate-700 sm:flex sm:flex-row-reverse gap-3">
                        <button wire:click="submitRequest" type="button" class="w-full inline-flex justify-center rounded-xl shadow-lg shadow-blue-500/20 border border-transparent px-5 py-2.5 bg-blue-600 text-base font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm transition-all transform active:scale-95">
                            Kirim Permintaan
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-300 dark:border-slate-600 shadow-sm px-5 py-2.5 bg-white dark:bg-slate-700 text-base font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>