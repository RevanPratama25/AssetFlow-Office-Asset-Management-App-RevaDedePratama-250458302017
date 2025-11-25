<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Verifikasi Pengembalian</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                Cek fisik aset yang dikembalikan staff sebelum mengembalikannya ke stok utama.
            </p>
        </div>

        {{-- Counter Pills Wrapper --}}
        <div class="flex flex-wrap gap-3">
            
            {{-- Pill 1: Perlu Verifikasi (Status 'Dikembalikan') --}}
            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                <span class="relative flex h-3 w-3 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-300">
                    Perlu Verifikasi: 
                    <span class="font-bold text-slate-900 dark:text-white ml-1">
                        {{ $returns->where('status', 'Dikembalikan')->count() }}
                    </span>
                </span>
            </div>

            {{-- Pill 2: Selesai (Status 'Selesai' / 'Terverifikasi') --}}
            <div class="inline-flex items-center px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
                <span class="relative flex h-3 w-3 mr-2">
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-300">
                    Selesai: 
                    <span class="font-bold text-slate-900 dark:text-white ml-1">
                        {{ $returns->where('status', 'Selesai')->count() }}
                    </span>
                </span>
            </div>

        </div> 
    </div>

    {{-- Alerts --}}
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-6 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-rose-50 dark:bg-rose-900/30 border-l-4 border-rose-500 text-rose-700 dark:text-rose-400 p-4 mb-6 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Detail Aset</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Waktu Dikembalikan</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($returns as $req)
                        <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150 group">
                            
                            {{-- Kolom Peminjam --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center text-sm font-bold mr-3 border border-slate-200 dark:border-slate-600">
                                        {{ substr($req->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $req->user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $req->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Aset --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $req->asset->name }}</div>
                                <div class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 font-mono">
                                    {{ $req->asset->asset_code }}
                                </div>
                            </td>

                            {{-- Kolom Waktu --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($req->updated_at)->format('d M Y, H:i') }}
                                </div>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if($req->status === 'Dikembalikan')
                                    <button wire:click="verify({{ $req->id }})" 
                                        wire:confirm="Pastikan fisik barang sudah dicek dan kondisinya baik. Lanjutkan?"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md shadow-blue-500/20 transition-all transform active:scale-95 group/btn">
                                        <svg class="w-4 h-4 mr-2 group-hover/btn:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Verifikasi & Terima
                                    </button>
                                @else
                                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-100 dark:border-emerald-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Terverifikasi
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                    <div class="bg-slate-100 dark:bg-slate-700/50 rounded-full p-4 mb-4">
                                        <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Semua Bersih!</h3>
                                    <p class="text-sm mt-1">Belum ada pengembalian aset yang perlu diverifikasi saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($returns->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                {{ $returns->links() }}
            </div>
        @endif
    </div>
</div>