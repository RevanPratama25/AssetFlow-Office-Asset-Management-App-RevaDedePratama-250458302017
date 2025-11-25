@extends('components.admin-layout')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h2>

    {{-- BARIS 1: KARTU STATISTIK UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-indigo-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Aset</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalAssets }}</p>
            </div>
            <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Tersedia</p>
                <p class="text-2xl font-bold text-gray-800">{{ $availableAssets }}</p>
            </div>
            <div class="p-3 bg-green-50 rounded-full text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-gray-800">{{ $borrowedAssets }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Maintenance/Rusak</p>
                <p class="text-2xl font-bold text-gray-800">{{ $maintenanceAssets }}</p>
            </div>
            <div class="p-3 bg-red-50 rounded-full text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- BARIS 2: TABEL & NOTIFIKASI --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Aktivitas Terbaru (Lebar 2/3) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Aktivitas Peminjaman Terbaru</h3>
                <a href="{{ route('admin.reports.borrowing') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase font-medium">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentActivities as $activity)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $activity->user->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $activity->asset->name }}</td>
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $activity->created_at->diffForHumans() }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $activity->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                          ($activity->status == 'Disetujui' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-gray-400">Belum ada aktivitas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- KOLOM KANAN: Alert / Action Needed (Lebar 1/3) --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-bold text-gray-800 mb-4">Butuh Perhatian</h3>
            
            @if($pendingRequests > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Ada <strong class="text-lg">{{ $pendingRequests }}</strong> permintaan peminjaman baru yang menunggu persetujuan.
                            </p>
                            <div class="mt-2">
                                <a href="{{ route('admin.admin.borrowings') }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-600 hover:underline">
                                    Proses Sekarang &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Tidak ada permintaan pending. Semua aman terkendali!
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <hr class="my-4 border-gray-100">
            
            <div class="text-sm text-gray-600">
                <p class="mb-2 flex justify-between">
                    <span>Sedang Dipinjam:</span>
                    <span class="font-bold">{{ $activeLoans }} Item</span>
                </p>
                <p class="flex justify-between">
                    <span>Maintenance:</span>
                    <span class="font-bold text-red-600">{{ $maintenanceAssets }} Item</span>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
