<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Aset Saya</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-base">
                Pantau riwayat peminjaman dan status pengajuan aset Anda di sini.
            </p>
        </div>
        
        {{-- Counter Pill --}}
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm">
            <span class="text-sm text-slate-500 dark:text-slate-400 mr-2">Total Riwayat:</span>
            <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $requests->count() }}</span>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Detail Barang</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Durasi Peminjaman</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($requests as $req)
                                                                                    <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-200">

                                                                                        {{-- Kolom Barang --}}
                                                                                        <td class="px-6 py-5 whitespace-nowrap">
                                                                                            <div class="flex items-center gap-4">
                                                                                                {{-- Icon Placeholder --}}
                                                                                                <div>
                                                                                                    <div class="text-sm font-bold text-slate-800 dark:text-white">
                                                                                                        {{ $req->asset->name ?? 'Aset Tidak Ditemukan' }}
                                                                                                    </div>
                                                                                                    <div class="text-xs font-mono text-slate-500 dark:text-slate-400 mt-0.5 bg-slate-100 dark:bg-slate-700/50 px-1.5 py-0.5 rounded inline-block">
                                                                                                        {{ $req->asset->asset_code ?? '-' }}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>

                                                                                        {{-- Kolom Tanggal --}}
                                                                                        <td class="px-6 py-5 whitespace-nowrap">
                                                                                            <div class="flex flex-col text-sm">
                                                                                                <div class="flex items-center text-slate-700 dark:text-slate-300">
                                                                                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                                                    {{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}
                                                                                                </div>
                                                                                                <div class="pl-[5px] py-1">
                                                                                                    <div class="h-3 border-l border-slate-300 dark:border-slate-600 ml-1.5"></div>
                                                                                                </div>
                                                                                                <div class="flex items-center text-slate-700 dark:text-slate-300">
                                                                                                    <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                                                    {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>

                                                                                        {{-- Kolom Status --}}
                                                                                        <td class="px-6 py-5 whitespace-nowrap text-center">
                                                                                            @php
                        $statusStyles = [
                            'Pending' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                            'Disetujui' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                            'Ditolak' => 'bg-rose-100 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800',
                            'Dikembalikan' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700/50 dark:text-slate-400 dark:border-slate-600',
                        ];
                        $style = $statusStyles[$req->status] ?? 'bg-gray-100 text-gray-700';
                                                                                            @endphp
                                                                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $style }}">
                                                                                                {{ $req->status }}
                                                                                            </span>
                                                                                        </td>

                                                                                        {{-- Kolom Catatan --}}
                                                                                        <td class="px-6 py-5">
                                                                                            <div class="text-sm text-slate-600 dark:text-slate-400 max-w-[200px] truncate" title="{{ $req->notes }}">
                                                                                                {{ $req->notes ?? '-' }}
                                                                                            </div>
                                                                                        </td>

                                                                                        {{-- Kolom Aksi --}}
                                                                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                                                            @if($req->status === 'Disetujui')
                                                                                                {{-- Kondisi 1: Barang sedang dipegang Staff --}}
                                                                                                <button wire:click="returnAsset({{ $req->id }})" wire:confirm="Apakah Anda yakin ingin mengembalikan aset ini?"
                                                                                                    class="bg-blue-600 text-white px-3 py-1.5 rounded-md hover:bg-blue-700 transition shadow-sm text-xs">
                                                                                                    Kembalikan Aset
                                                                                                </button>

                                                                                            @elseif($req->status === 'Dikembalikan')
                                                                                                {{-- Kondisi 2: Staff sudah klik kembali, menunggu Admin --}}
                                                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                                                    <svg class="mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                                                                                        <circle cx="4" cy="4" r="3" />
                                                                                                    </svg>
                                                                                                    Menunggu Verifikasi
                                                                                                </span>

                                                                                            @elseif($req->status === 'Tersedia')
                                                                                                {{-- Kondisi 3: Admin sudah memverifikasi --}}
                                                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                                                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                                                                        <circle cx="4" cy="4" r="3" />
                                                                                                    </svg>
                                                                                                    Selesai
                                                                                                </span>

                                                                                            @elseif($req->status === 'Ditolak')
                                                                                                <span class="text-red-500 text-xs">Permintaan Ditolak</span>

                                                                                            @elseif($req->status === 'Selesai')
                                                                                                <span class="text-gray-500 text-xs">Pengembalian Telah Diverifikasi</span>

                                                                                            @else
                                                                                                <span class="text-gray-400 text-xs">Pending</span>
                                                                                            @endif
                                                                                        </td>
                                                                                        </tr>
                    @empty
                                                    <tr>
                                                        <td colspan="5" class="px-6 py-16 text-center">
                                                            <div class="flex flex-col items-center justify-center">
                                                                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-full p-4 mb-3">
                                                                    <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                                    </svg>
                                                                </div>
                                                                <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada riwayat peminjaman.</p>
                                                                <a href="{{ route('staff.assets') }}"
                                                                    class="text-blue-600 dark:text-blue-400 hover:underline mt-2 text-sm font-semibold">
                                                                    Ajukan Peminjaman Baru &rarr;
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                                </table>
                                                </div>
        
        {{-- Pagination --}}
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>