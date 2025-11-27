<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Detail Aset</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                Informasi lengkap, spesifikasi, dan riwayat penggunaan aset.
            </p>
        </div>
        <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-sm text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: KARTU IDENTITAS ASET --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                
                {{-- Gambar Aset --}}
                <div class="relative aspect-video bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center overflow-hidden group">
                    @if($asset->image || $asset->photo_url)
                        <img src="{{ $asset->image ? Storage::url($asset->image) : asset('storage/' . $asset->photo_url) }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="flex flex-col items-center text-slate-400 dark:text-slate-500">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-sm">Tidak ada gambar</span>
                        </div>
                    @endif
                    
                    {{-- Status Badge Overlay --}}
                    <div class="absolute top-4 right-4">
                        @php
                            $statusClass = match($asset->status) {
                                'Tersedia' => 'bg-emerald-500 text-white',
                                'Dipinjam', 'Dipakai' => 'bg-amber-500 text-white',
                                'Rusak', 'Dalam Perbaikan' => 'bg-rose-500 text-white',
                                default => 'bg-slate-500 text-white'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold shadow-md {{ $statusClass }}">
                            {{ $asset->status }}
                        </span>
                    </div>
                </div>

                {{-- Info Utama --}}
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1 leading-tight">{{ $asset->name }}</h3>
                        <div class="inline-block bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-mono px-2 py-1 rounded border border-slate-200 dark:border-slate-600">
                            {{ $asset->asset_code }}
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Kategori</span>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $asset->category->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Lokasi</span>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $asset->location->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-700 pb-3">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Tipe</span>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 capitalize">{{ $asset->using_type }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Tanggal Beli</span>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-1">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Harga Beli</span>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200">Rp {{ number_format($asset->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TABS DATA --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 min-h-[500px] flex flex-col overflow-hidden">
                
                {{-- Tab Navigation --}}
                <div class="flex border-b border-slate-200 dark:border-slate-700 overflow-x-auto">
                    @foreach([
                        'info' => 'Spesifikasi', 
                        'borrowings' => 'Riwayat Peminjaman', 
                        'maintenance' => 'Riwayat Perbaikan'
                    ] as $key => $label)
                        <button wire:click="setTab('{{ $key }}')" 
                            class="px-6 py-4 text-sm font-medium border-b-2 transition-colors duration-200 focus:outline-none whitespace-nowrap
                            {{ $activeTab === $key 
                                ? 'border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-400' 
                                : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:border-slate-300' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="p-6 flex-1">
                    
                    {{-- CONTENT: INFO --}}
                    @if($activeTab === 'info')
                        <div class="animate-fade-in">
                            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Deskripsi & Spesifikasi Detail</h4>
                            <div class="prose prose-slate dark:prose-invert max-w-none text-sm text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 p-5 rounded-xl border border-slate-100 dark:border-slate-700">
                                @if($asset->description)
                                    {!! nl2br(e($asset->description)) !!}
                                @else
                                    <p class="text-slate-400 italic">Tidak ada deskripsi tambahan untuk aset ini.</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- CONTENT: BORROWINGS --}}
                    @if($activeTab === 'borrowings')
                        {{-- Tambahkan overflow-x-auto disini --}}
                        <div class="animate-fade-in rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                            <div class="overflow-x-auto w-full"> 
                                <table class="min-w-full text-sm text-left">
                                    <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 font-semibold uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3 whitespace-nowrap">Peminjam</th>
                                            <th class="px-4 py-3 whitespace-nowrap">Tgl Pinjam</th>
                                            <th class="px-4 py-3 whitespace-nowrap">Tgl Kembali</th>
                                            <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                        @forelse($borrowings as $log)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                                <td class="px-4 py-3 font-medium text-slate-800 dark:text-white whitespace-nowrap">
                                                    {{ $log->user->name }}
                                                </td>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($log->start_date)->format('d M Y') }}
                                                </td>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                                    {{ $log->return_date ? \Carbon\Carbon::parse($log->return_date)->format('d M Y') : '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                                    @php
                                                        $statusClass = match($log->status) {
                                                            'Disetujui', 'Dipinjam' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                            'Dikembalikan', 'Selesai' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                                            'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                                            'Ditolak' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300',
                                                            default => 'bg-slate-100 text-slate-800'
                                                        };
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $statusClass }}">
                                                        {{ $log->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-8 text-slate-500 dark:text-slate-400">
                                                    Belum ada riwayat peminjaman.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                {{ $borrowings->links() }}
                            </div>
                        </div>
                    @endif

                    {{-- CONTENT: MAINTENANCE --}}
                    @if($activeTab === 'maintenance')
                        {{-- Tambahkan overflow-x-auto disini untuk scroll horizontal --}}
                        <div class="animate-fade-in rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                            <div class="overflow-x-auto w-full">
                                <table class="min-w-full text-sm text-left">
                                    <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 font-semibold uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3 whitespace-nowrap">Tgl Lapor</th>
                                            {{-- Beri min-width agar kolom tidak penyet --}}
                                            <th class="px-4 py-3 min-w-[200px]">Masalah</th>
                                            <th class="px-4 py-3 min-w-[200px]">Tindakan</th>
                                            <th class="px-4 py-3 whitespace-nowrap">Biaya</th>
                                            <th class="px-4 py-3 text-center whitespace-nowrap">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800">
                                        @forelse($maintenances as $log)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 whitespace-nowrap align-top">
                                                    {{ \Carbon\Carbon::parse($log->reported_at)->format('d M Y') }}
                                                </td>
                                                
                                                {{-- Gunakan text-wrap normal agar bisa turun ke bawah jika perlu, tapi min-w menjamin lebar --}}
                                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 align-top">
                                                    {{ $log->problem_description }}
                                                </td>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 align-top">
                                                    {{ $log->action_taken ?? '-' }}
                                                </td>
                                                
                                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 font-mono whitespace-nowrap align-top">
                                                    Rp {{ number_format($log->cost ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-center whitespace-nowrap align-top">
                                                    <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $log->status == 'Selesai' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300' }}">
                                                        {{ $log->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-8 text-slate-500 dark:text-slate-400">
                                                    Belum ada riwayat perbaikan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                {{ $maintenances->links() }}
                            </div>
                        </div>
                    @endif
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>