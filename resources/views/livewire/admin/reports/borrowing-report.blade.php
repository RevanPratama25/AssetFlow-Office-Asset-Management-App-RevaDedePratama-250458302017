<div class="p-6">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Laporan Peminjaman</h2>
        
        {{-- Tombol Export --}}
        <button wire:click="downloadPdf" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 shadow flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Download PDF
        </button>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" wire:model.live="startDate" class="w-full border rounded p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" wire:model.live="endDate" class="w-full border rounded p-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                <select wire:model.live="status" class="w-full border rounded p-2 text-sm">
                    <option value="Semua">Semua Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Disetujui">Disetujui</option>
                    <option value="Dikembalikan">Dikembalikan</option>
                    <option value="Selesai">Selesai/Terverifikasi</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Tabel Preview --}}
    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aset</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Pinjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Kembali</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($borrowings as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->asset->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded 
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>