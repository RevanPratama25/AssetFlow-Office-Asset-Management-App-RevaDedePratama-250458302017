@extends('components.admin-layout')

@section('content')
<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Dashboard Overview</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Ringkasan statistik dan aktivitas aset terkini.</p>
    </div>

    {{-- BARIS 1: KARTU STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- Total Aset --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between hover:shadow-lg transition-all duration-300 group">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Aset</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $totalAssets }}</p>
            </div>
            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        {{-- Tersedia --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between hover:shadow-lg transition-all duration-300 group">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tersedia</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $availableAssets }}</p>
            </div>
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between hover:shadow-lg transition-all duration-300 group">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Dipinjam</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $borrowedAssets }}</p>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        {{-- Maintenance --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between hover:shadow-lg transition-all duration-300 group">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Perbaikan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $maintenanceAssets }}</p>
            </div>
            <div class="p-3 bg-rose-50 dark:bg-rose-900/30 rounded-xl text-rose-600 dark:text-rose-400 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
        </div>
    </div>
    
    {{-- BARIS 2: GRAFIK --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Grafik Pie --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="font-bold text-slate-800 dark:text-white mb-6 text-lg border-b border-slate-100 dark:border-slate-700 pb-4">Komposisi Status Aset</h3>
            <div class="relative h-72 w-full flex justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        {{-- Grafik Bar --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="font-bold text-slate-800 dark:text-white mb-6 text-lg border-b border-slate-100 dark:border-slate-700 pb-4">Jumlah Aset per Kategori</h3>
            <div class="relative h-72 w-full">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    {{-- BARIS 3: TABEL & NOTIFIKASI --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Aktivitas Terbaru (Lebar 2/3) --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="font-bold text-slate-800 dark:text-white">Aktivitas Peminjaman Terbaru</h3>
                <a href="{{ route('admin.reports.borrowing') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">Lihat Semua &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 uppercase font-semibold text-xs">
                        <tr>
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Barang</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($recentActivities as $activity)
                            <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors">
                                <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $activity->user->name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $activity->asset->name }}</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-500 text-xs">{{ $activity->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match($activity->status) {
                                            'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                            'Disetujui' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'Dikembalikan', 'Selesai' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                            default => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $statusClass }}">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-slate-400 dark:text-slate-500">Belum ada aktivitas terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KOLOM KANAN: Alert / Action Needed (Lebar 1/3) --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 p-6 flex flex-col">
            <h3 class="font-bold text-slate-800 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">Butuh Perhatian</h3>
            
            @if($pendingRequests > 0)
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-5 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 p-2 bg-amber-100 dark:bg-amber-800/50 rounded-lg text-amber-600 dark:text-amber-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-amber-800 dark:text-amber-200 font-medium">
                                Ada <strong class="text-lg">{{ $pendingRequests }}</strong> permintaan baru yang menunggu persetujuan.
                            </p>
                            <a href="{{ route('admin.admin.borrowings') }}" class="mt-3 inline-block text-sm font-bold text-amber-700 dark:text-amber-400 hover:text-amber-800 hover:underline">
                                Proses Sekarang &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl p-5 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="shrink-0 p-2 bg-emerald-100 dark:bg-emerald-800/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm text-emerald-800 dark:text-emerald-200 font-medium">
                            Tidak ada permintaan pending. Semua aman terkendali!
                        </p>
                    </div>
                </div>
            @endif

            <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Statistik Cepat</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <span class="text-slate-600 dark:text-slate-300">Sedang Dipinjam</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $activeLoans }} Item</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <span class="text-slate-600 dark:text-slate-300">Perbaikan</span>
                        <span class="font-bold text-rose-600 dark:text-rose-400">{{ $maintenanceAssets }} Item</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Script Chart.js --}}
<script>
    document.addEventListener('livewire:initialized', () => {
        // Konfigurasi Global Chart agar support Dark Mode (Opsional, basic)
        Chart.defaults.color = '#94a3b8'; 
        Chart.defaults.borderColor = '#cbd5e1';

        // --- CHART 1 (DOUGHNUT) ---
        const ctxStatus = document.getElementById('statusChart');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: @json($chartStatusLabels),
                datasets: [{
                    label: 'Jumlah Aset',
                    data: @json($chartStatusValues),
                    backgroundColor: [
                        '#10B981', // Emerald (Tersedia)
                        '#3B82F6', // Blue (Dipinjam)
                        '#EF4444', // Rose (Rusak)
                        '#F59E0B', // Amber (Maintenance)
                        '#64748B'  // Slate (Lainnya)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: { padding: 20, usePointStyle: true } 
                    }
                },
                cutout: '50%', // Tebal donat -> Ukuran lubang tengah
            }
        });

        // --- CHART 2 (BAR) ---
        const ctxCategory = document.getElementById('categoryChart');
        new Chart(ctxCategory, {
            type: 'bar',
            data: {
                labels: @json($chartCategoryLabels),
                datasets: [{
                    label: 'Jumlah Item',
                    data: @json($chartCategoryValues),
                    backgroundColor: '#6366F1', // Indigo primary
                    borderRadius: 6,
                    barThickness: 30,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { precision: 0 },
                        grid: { display: true, borderDash: [2, 2] } // Grid putus-putus
                    },
                    x: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection