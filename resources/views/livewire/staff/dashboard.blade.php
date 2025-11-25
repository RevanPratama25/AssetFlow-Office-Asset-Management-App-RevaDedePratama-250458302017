<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Sapaan Selamat Datang --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-gray-600">Selamat datang di AssetFlow. Berikut adalah ringkasan peminjaman Anda.</p>
        </div>

        {{-- GRID KARTU STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white rounded-xl shadow p-6 border-t-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Sedang Dipinjam</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activeLoans }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('staff.my-assets') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        Lihat Detail <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border-t-4 border-yellow-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Menunggu Admin</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingRequests }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-full text-yellow-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    Permintaan sedang diproses
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 border-t-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase">Riwayat Selesai</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $completedHistory }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    Transaksi berhasil diselesaikan
                </div>
            </div>

        </div>

        {{-- TABEL RINGKAS TERAKHIR --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Aktivitas Terakhir Anda</h3>
                <a href="{{ route('staff.assets') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Pinjam Barang Baru &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aset</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentRequests as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->asset->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->asset->asset_code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($item->status == 'Pending') bg-yellow-100 text-yellow-800 
                                        @elseif($item->status == 'Disetujui') bg-blue-100 text-blue-800 
                                        @elseif($item->status == 'Selesai') bg-green-100 text-green-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Anda belum melakukan peminjaman apapun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>