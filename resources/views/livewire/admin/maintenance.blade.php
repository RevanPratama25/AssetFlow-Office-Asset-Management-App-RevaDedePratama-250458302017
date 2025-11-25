<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Manajemen Perbaikan</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">
                Monitor status perbaikan aset dan kelola laporan kerusakan.
            </p>
        </div>
        
        {{-- Tombol Lapor (Merah/Rose untuk Urgensi) --}}
        <button wire:click="openCreateModal" class="group flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-rose-500/30 transition-all transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Lapor Kerusakan
        </button>
    </div>

    {{-- Alerts --}}
    @if (session()->has('message'))
        <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-6 rounded-r-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    {{-- TABEL MONITORING --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Masalah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pelapor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tgl Lapor</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($activeMaintenances as $log)
                        <tr class="hover:bg-rose-50/30 dark:hover:bg-rose-900/10 transition-colors duration-150 group">
                            {{-- Kolom Aset --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $log->asset->name }}</div>
                                    <div class="text-xs font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded inline-block w-fit mt-1 border border-slate-200 dark:border-slate-600">
                                        {{ $log->asset->asset_code }}
                                    </div>
                                </div>
                            </td>
                            {{-- Kolom Masalah --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-700 dark:text-slate-300 max-w-xs">
                                    {{ $log->problem_description }}
                                </div>
                            </td>
                            {{-- Kolom Pelapor --}}
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold">
                                        {{ substr($log->reporter->name ?? 'S', 0, 1) }}
                                    </div>
                                    {{ $log->reporter->name ?? 'Sistem' }}
                                </div>
                            </td>
                            {{-- Kolom Tanggal --}}
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($log->reported_at)->format('d M Y') }}
                            </td>
                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <button wire:click="openCompleteModal({{ $log->id }})" 
                                        class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 hover:text-white hover:bg-emerald-600 font-medium text-sm border border-emerald-600 dark:border-emerald-500 px-3 py-1.5 rounded-lg transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Selesaikan
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-slate-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-slate-100 dark:bg-slate-700/50 rounded-full p-4 mb-4">
                                        <svg class="h-10 w-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Aman Terkendali!</h3>
                                    <p class="text-sm mt-1">Tidak ada aset yang sedang dalam perbaikan saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL 1: LAPOR KERUSAKAN (CREATE) --}}
    @if($isCreateModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Overlay --}}
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" wire:click="closeCreateModal"></div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="relative bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg w-full border border-slate-200 dark:border-slate-700">
                
                {{-- Header Modal --}}
                <div class="bg-rose-50 dark:bg-rose-900/20 px-6 py-5 border-b border-rose-100 dark:border-rose-800/50 flex items-center gap-3">
                    <div class="p-2 bg-rose-100 dark:bg-rose-800 rounded-lg text-rose-600 dark:text-rose-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                        Lapor Aset Rusak
                    </h3>
                </div>

                <div class="px-6 py-6 space-y-5">
                    {{-- Select Aset --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Pilih Aset</label>
                        <div class="relative">
                            <select wire:model="asset_id" class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-rose-500 focus:border-rose-500 transition">
                                <option value="">-- Pilih Aset --</option>
                                @foreach($availableAssets as $asset)
                                    <option value="{{ $asset->id }}">
                                        {{ $asset->name }} ({{ $asset->asset_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('asset_id') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi Masalah</label>
                        <textarea wire:model="problem_description" class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-rose-500 focus:border-rose-500 transition placeholder-slate-400" rows="3" placeholder="Jelaskan kerusakan yang terjadi secara detail..."></textarea>
                        @error('problem_description') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Footer Modal --}}
                <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex justify-end gap-3">
                    <button wire:click="closeCreateModal" class="px-5 py-2.5 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition font-medium text-sm">
                        Batal
                    </button>
                    <button wire:click="store" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl hover:bg-rose-700 transition font-bold text-sm shadow-lg shadow-rose-500/20 transform active:scale-95">
                        Simpan & Proses
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- MODAL 2: SELESAIKAN PERBAIKAN (COMPLETE) --}}
    @if($isCompleteModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Overlay --}}
            <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" wire:click="closeCompleteModal"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg w-full border border-slate-200 dark:border-slate-700">

                    {{-- Header Modal --}}
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 px-6 py-5 border-b border-emerald-100 dark:border-emerald-800/50 flex items-center gap-3">
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">
                            Penyelesaian Perbaikan
                        </h3>
                    </div>

                    <div class="px-6 py-6 space-y-5">
                        {{-- Tindakan --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tindakan yang Diambil</label>
                            <textarea wire:model="action_taken" class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition placeholder-slate-400" rows="3" placeholder="Contoh: Mengganti LCD Monitor, Install ulang OS..."></textarea>
                            @error('action_taken') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Biaya (Alpine JS) --}}
                        <div x-data="{
                            cost: @entangle('cost'),
                            formatRupiah(value) {
                                if (!value) return '';
                                return 'Rp ' + parseInt(value).toLocaleString('id-ID');
                            },
                            handleInput(e) {
                                let rawValue = e.target.value.replace(/[^0-9]/g, '');
                                this.cost = rawValue ? parseInt(rawValue) : '';
                                e.target.value = this.formatRupiah(this.cost);
                            }
                        }">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Biaya Perbaikan</label>
                            <input type="text" :value="formatRupiah(cost)" @input="handleInput($event)"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition font-mono"
                                placeholder="Rp 0">
                            @error('cost') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Footer Modal --}}
                    <div class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 border-t border-slate-100 dark:border-slate-700 flex justify-end gap-3">
                        <button wire:click="closeCompleteModal" class="px-5 py-2.5 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition font-medium text-sm">
                            Batal
                        </button>
                        <button wire:click="updateAndComplete" class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-bold text-sm shadow-lg shadow-emerald-500/20 transform active:scale-95">
                            Selesai & Tersedia
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>