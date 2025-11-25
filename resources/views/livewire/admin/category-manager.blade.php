<div class="min-h-screen p-6 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
    
    {{-- Header Section & Action Button --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Manajemen Kategori Aset</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Kelola pengelompokan jenis aset agar lebih terorganisir.</p>
        </div>
        
        <button wire:click="create" class="mt-4 md:mt-0 flex items-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-medium py-2.5 px-5 rounded-lg shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Kategori
        </button>
    </div>

    {{-- Alert Messages --}}
    @if (session()->has('success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-700 dark:text-emerald-400 p-4 mb-6 rounded-r-lg shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <span class="font-bold">Sukses!</span> {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Data Table Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Kategori</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Deskripsi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-colors duration-150 group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800 dark:text-white">{{ $category->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $category->description ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <button wire:click="edit({{ $category->id }})" class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900/30" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="delete({{ $category->id }})"
                                    wire:confirm="Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan."
                                    class="text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors p-1 rounded hover:bg-rose-50 dark:hover:bg-rose-900/30" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                    <svg class="h-12 w-12 mb-3 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <span class="text-base font-medium">Belum ada data kategori yang tersedia.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Form --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-auto bg-slate-900/75 backdrop-blur-sm flex transition-opacity duration-300">
            <div class="relative p-0 bg-white dark:bg-slate-800 w-full max-w-lg m-auto flex-col flex rounded-xl shadow-2xl border border-slate-200 dark:border-slate-700">
                
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50 rounded-t-xl">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        {{ $categoryId ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </h3>
                    <button wire:click="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6">
                    <form wire:submit.prevent="store">
                        <div class="space-y-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama Kategori</label>
                                <input type="text" id="name" wire:model.defer="name" 
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400" 
                                    placeholder="Contoh: Elektronik, Kendaraan...">
                                @error('name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                <textarea id="description" wire:model.defer="description" rows="4" 
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:focus:ring-blue-500/20 transition placeholder-slate-400" 
                                    placeholder="Jelaskan peruntukan kategori ini..."></textarea>
                                @error('description') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="mt-8 flex items-center justify-end space-x-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <button type="button" wire:click="closeModal()" class="bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-600 font-medium transition-all duration-200">
                                Batal
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md shadow-blue-500/20 font-medium transition-all duration-200 transform active:scale-95">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>