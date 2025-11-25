<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Permintaan Peminjaman</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                Daftar pengajuan aset yang menunggu keputusan persetujuan Anda.
            </p>
        </div>
        
        {{-- Counter Pill --}}
        <div class="inline-flex items-center px-4 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
            <span class="relative flex h-3 w-3 mr-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
            </span>
            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Menunggu: <span class="font-bold text-slate-900 dark:text-white">{{ $requests->count() }}</span></span>
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
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jadwal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keperluan</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($requests as $req)
                        <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150 group">
                            
                            {{-- Kolom Peminjam --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center text-sm font-bold mr-3">
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

                            {{-- Kolom Jadwal --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1 text-sm">
                                    <div class="flex items-center text-slate-700 dark:text-slate-300">
                                        <span class="w-14 text-xs text-slate-400 uppercase font-bold">Mulai</span>
                                        <span class="font-medium text-emerald-600 dark:text-emerald-400">{{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center text-slate-700 dark:text-slate-300">
                                        <span class="w-14 text-xs text-slate-400 uppercase font-bold">Selesai</span>
                                        <span class="font-medium text-rose-600 dark:text-rose-400">{{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Keperluan --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 max-w-xs truncate" title="{{ $req->notes }}">
                                    {{ $req->notes ?? '-' }}
                                </div>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center space-x-2">
                                    {{-- Tombol Setuju (Hijau/Emerald untuk Admin agar jelas) --}}
                                    <button wire:click="approve({{ $req->id }})" 
                                        wire:confirm="Setujui peminjaman ini? Status aset akan berubah menjadi 'Dipakai'."
                                        class="group/btn inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-all shadow-md shadow-emerald-500/20 transform active:scale-95"
                                        title="Setujui">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Setuju
                                    </button>

                                    {{-- Tombol Tolak (Merah/Rose) --}}
                                    <button wire:click="reject({{ $req->id }})" 
                                        wire:confirm="Yakin ingin menolak permintaan ini?"
                                        class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-slate-700 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 text-xs font-bold rounded-lg transition-all"
                                        title="Tolak">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                    <div class="bg-slate-100 dark:bg-slate-700/50 rounded-full p-4 mb-4">
                                        <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Semua Beres!</h3>
                                    <p class="text-sm mt-1">Tidak ada permintaan peminjaman baru saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Jika ada) --}}
        @if(method_exists($requests, 'links'))
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>