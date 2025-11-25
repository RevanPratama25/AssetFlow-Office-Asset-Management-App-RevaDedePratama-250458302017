<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300 flex justify-center">
    <div class="w-full max-w-3xl">
        
        {{-- Header Section --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-100 dark:bg-rose-900/30 mb-4">
                <svg class="w-8 h-8 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Lapor Kerusakan</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">
                Temukan kerusakan pada aset? Segera laporkan agar dapat kami tindak lanjuti.
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden p-6 sm:p-8 transition-all duration-300">
            
            {{-- Notifikasi Sukses --}}
            @if (session()->has('message'))
                <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-8 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('message') }}
                </div>
            @endif

            {{-- TAHAP 1: PENCARIAN ASET --}}
            @if(!$selectedAsset)
                <div class="mb-6 space-y-4">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">Cari Aset yang Rusak</label>
                    <div class="relative">
                        <input type="text" wire:model.live="search" placeholder="Ketik Nama atau Kode Aset (min. 2 huruf)..." 
                               class="w-full pl-12 pr-4 py-3 rounded-xl border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all placeholder-slate-400">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Hasil Pencarian --}}
                    @if(strlen($search) >= 2)
                        <div class="mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-2xl max-h-60 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700/50 z-10 relative">
                            @forelse($results as $asset)
                                <div wire:click="selectAsset({{ $asset->id }})" 
                                     class="p-4 hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer flex justify-between items-center transition group">
                                    <div>
                                        <div class="font-bold text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $asset->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-mono">{{ $asset->asset_code }} • {{ $asset->category->name ?? '-' }}</div>
                                    </div>
                                    <span class="px-2.5 py-0.5 text-xs font-bold rounded-full border {{ $asset->status == 'Rusak' ? 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800' : 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800' }}">
                                        {{ $asset->status }}
                                    </span>
                                </div>
                            @empty
                                <div class="p-6 text-center text-slate-500 dark:text-slate-400 text-sm flex flex-col items-center">
                                    <svg class="w-8 h-8 mb-2 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Aset tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            @endif

            {{-- TAHAP 2: FORMULIR LAPORAN --}}
            @if($selectedAsset)
                <div class="animate-fade-in-up space-y-6">
                    
                    {{-- Selected Asset Card --}}
                    <div class="flex justify-between items-start bg-slate-50 dark:bg-slate-700/30 p-5 rounded-xl border border-slate-200 dark:border-slate-700">
                        <div class="flex gap-4">
                            <div class="bg-white items-center dark:bg-slate-800 p-3 rounded-lg border border-slate-200 dark:border-slate-600 text-blue-600 dark:text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $selectedAsset->name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 font-mono">{{ $selectedAsset->asset_code }}</p>
                                <div class="flex items-center mt-1 text-xs text-slate-400 dark:text-slate-500">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $selectedAsset->location->name ?? 'Lokasi tidak diketahui' }}
                                </div>
                            </div>
                        </div>
                        <button wire:click="resetSelection" class="text-sm font-medium text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 hover:underline transition">Ganti</button>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Deskripsi Kerusakan <span class="text-rose-500">*</span></label>
                            <textarea wire:model="description" rows="4" 
                                      class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition placeholder-slate-400" 
                                      placeholder="Jelaskan detail kerusakan... (Contoh: Layar bergaris saat dinyalakan)"></textarea>
                            @error('description') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Upload Foto Area --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Bukti Foto (Opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 dark:border-slate-600 border-dashed rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition group cursor-pointer relative">
                                
                                <input id="file-upload" wire:model="photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                
                                <div class="space-y-1 text-center">
                                    @if ($photo)
                                        {{-- Preview State --}}
                                        <div class="text-emerald-600 dark:text-emerald-400 mb-2">
                                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-sm font-medium">Foto berhasil dipilih</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $photo->getClientOriginalName() }}</p>
                                        </div>
                                    @else
                                        {{-- Empty State --}}
                                        <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center mt-2">
                                            <span class="relative font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                                Upload file
                                            </span>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">PNG, JPG, GIF hingga 2MB</p>
                                    @endif
                                </div>
                            </div>
                            @error('photo') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button wire:click="submitReport" wire:loading.attr="disabled" class="w-full bg-slate-900 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-slate-900/20 dark:shadow-blue-600/30 transition-all transform active:scale-95 flex justify-center items-center gap-2">
                            <span wire:loading.remove class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Laporan
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>