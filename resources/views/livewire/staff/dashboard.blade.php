<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    <div class="max-w-7xl mx-auto">
        
        {{-- Sapaan Selamat Datang --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">
                Halo, {{ Auth::user()->name }}! 
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-base">
                Selamat datang kembali di AssetFlow. Berikut adalah ringkasan aktivitas aset Anda.
            </p>
        </div>

        {{-- GRID KARTU STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            {{-- Card 1: Sedang Dipinjam --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border-t-4 border-blue-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sedang Dipakai</p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $activeLoans }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('staff.my-assets') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 group">
                        Lihat Detail 
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            {{-- Card 2: Menunggu Admin --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border-t-4 border-amber-400 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Menunggu Admin</p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $pendingRequests }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-500 dark:text-amber-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Permintaan sedang diproses</span>
                </div>
            </div>

            {{-- Card 3: Riwayat Selesai --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border-t-4 border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Riwayat Selesai</p>
                        <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $completedHistory }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-500 dark:text-slate-400">Transaksi berhasil diselesaikan</span>
                </div>
            </div>

        </div>

        {{-- AREA GRAFIK --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            {{-- Grafik 1 --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                <h3 class="font-bold text-slate-800 dark:text-white mb-6 text-lg border-b border-slate-100 dark:border-slate-700 pb-4">Status Peminjaman Saya</h3>
                <div class="relative h-64 w-full flex justify-center">
                    <canvas id="staffStatusChart"></canvas>
                </div>
            </div>

            {{-- Grafik 2 --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-slate-200 dark:border-slate-700">
                <h3 class="font-bold text-slate-800 dark:text-white mb-6 text-lg border-b border-slate-100 dark:border-slate-700 pb-4">Kategori Favorit Saya</h3>
                <div class="relative h-64 w-full">
                    <canvas id="staffCategoryChart"></canvas>
                </div>
            </div>

        </div>

        {{-- SCRIPT CHART.JS --}}
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Set Global Chart Colors for Dark Mode compatibility if needed
                Chart.defaults.color = '#94a3b8';
                Chart.defaults.borderColor = '#334155';

                // Chart 1: Status (Doughnut)
                const ctxStatus = document.getElementById('staffStatusChart');
                if (@json($chartStatusLabels).length > 0) {
                    new Chart(ctxStatus, {
                        type: 'doughnut',
                        data: {
                            labels: @json($chartStatusLabels),
                            datasets: [{
                                label: 'Jumlah',
                                data: @json($chartStatusValues),
                                backgroundColor: [
                                    '#10B981', // Dipakai Blue (3B82F6) 
                                    '#3B82F6', // Tersedia Amber (10B981)10B981
                                    '#F59E0B', // Rusak Emerald () EF4444
                                    '#EF4444', // Maintenance Rose (EF4444) F59E0B
                                    '#64748B'  // Slate (64748B)
                                ],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                            },
                            cutout: '50%',
                        }
                    });
                } else {
                    ctxStatus.parentElement.innerHTML = '<div class="flex flex-col items-center justify-center h-full text-slate-400"><svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><p>Belum ada data peminjaman.</p></div>';
                }

                // Chart 2: Kategori (Bar)
                const ctxCategory = document.getElementById('staffCategoryChart');
                if (@json($chartCategoryLabels).length > 0) {
                    new Chart(ctxCategory, {
                        type: 'bar',
                        data: {
                            labels: @json($chartCategoryLabels),
                            datasets: [{
                                label: 'Jumlah Item',
                                data: @json($chartCategoryValues),
                                backgroundColor: '#6366F1', // Indigo
                                borderRadius: 6,
                                barThickness: 50,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: { beginAtZero: true, ticks: { precision: 0 }, grid: { borderDash: [2, 4] } },
                                x: { grid: { display: false } }
                            },
                            plugins: { legend: { display: false } }
                        }
                    });
                } else {
                    ctxCategory.parentElement.innerHTML = '<div class="flex flex-col items-center justify-center h-full text-slate-400"><svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg><p>Belum ada data kategori.</p></div>';
                }
            });
        </script>

        {{-- TABEL RINGKAS TERAKHIR --}}
        <div class="bg-white dark:bg-slate-800 shadow-xl rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Aktivitas Terakhir Anda</h3>
                <a href="{{ route('staff.assets') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
                    Pinjam Barang Baru &rarr;
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aset</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($recentRequests as $item)
                            <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $item->asset->name }}</div>
                                    <div class="text-xs font-mono text-slate-500 dark:text-slate-400 mt-0.5 bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded inline-block">{{ $item->asset->asset_code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                    {{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $statusClass = match($item->status) {
                                            'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border-amber-200 dark:border-amber-800',
                                            'Disetujui' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                                            'Selesai', 'Dikembalikan' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
                                            default => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Anda belum melakukan peminjaman apapun.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>