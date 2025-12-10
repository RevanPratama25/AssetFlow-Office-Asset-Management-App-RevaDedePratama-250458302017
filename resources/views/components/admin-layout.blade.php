@extends('layouts.base')

@section('body')
    <div class="antialiased text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-900">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex overflow-hidden">

        {{-- OVERLAY MOBILE --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm md:hidden transition-opacity duration-300"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        {{-- SIDEBAR --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed z-50 inset-y-0 left-0 w-72 transition-transform duration-300 transform bg-white dark:bg-slate-800 md:relative md:translate-x-0 flex flex-col shadow-2xl md:shadow-xl border-r border-slate-200 dark:border-slate-700">

            {{-- HEADER SIDEBAR --}}
            <div class="flex items-center justify-center h-20 bg-blue-700 dark:bg-slate-900 border-b border-blue-600 dark:border-slate-700 shadow-sm relative overflow-hidden">
                {{-- Background Decoration --}}
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 rounded-full bg-white/10 blur-xl"></div>
                <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-20 h-20 rounded-full bg-white/10 blur-xl"></div>

                <div class="flex items-center gap-3 relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <a href="{{ route('home') }}">
                            <x-logo class="w-auto h-10 pb-0 mx-auto mb-0 text-indigo-450" />
                        </a>
                    </a>
                    <span class="text-xl font-bold text-blue-600 tracking-wide">
                        AssetFlow
                    </span>
                </div>

                {{-- Tombol Tutup (Mobile) --}}
                <button @click="sidebarOpen = false" class="absolute right-4 top-1/2 -translate-y-1/2 md:hidden text-white/80 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- NAVIGASI --}}
            <div class="flex flex-col flex-1 overflow-y-auto py-6 px-4 space-y-1">

                {{-- 1. Dashboard & Users --}}
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-2">Main Menu</p>

                <a href="{{ route('admin.overview') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.overview')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.overview') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.users.index')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.users.index') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Pengguna
                </a>

                {{-- 2. Master Data (Aset) --}}
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Master Data</p>

                <a href="{{ route('admin.assets.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.assets.*')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.assets.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Data Aset
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.categories.*')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori
                </a>

                <a href="{{ route('admin.locations.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.locations.*')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.locations.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Lokasi
                </a>

                {{-- 3. Sirkulasi & Transaksi --}}
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Sirkulasi</p>

                <a href="{{ route('admin.admin.borrowings') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.admin.borrowings')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.admin.borrowings') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pengajuan Masuk
                </a>

                <a href="{{ route('admin.admin.returns') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.admin.returns')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.admin.returns') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Verifikasi Kembali
                </a>

                {{-- 4. Laporan --}}
                <p class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 mt-6">Laporan & Perbaikan</p>

                <a href="{{ route('admin.admin.maintenance') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.admin.maintenance')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.admin.maintenance') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Kerusakan
                </a>

                <a href="{{ route('admin.reports.borrowing') }}" 
                   class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 group
                   {{ request()->routeIs('admin.reports.*')
    ? 'bg-blue-600 text-white shadow-md shadow-blue-500/30'
    : 'text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600 dark:text-slate-500 dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Pemakaian
                </a>

            </div>

            {{-- LOGOUT --}}
            <div class="p-4 border-t border-slate-200 dark:border-slate-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/20 rounded-xl hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white transition-all duration-200 shadow-sm">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50 dark:bg-slate-900">

            {{-- Mobile Header --}}
            <header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 md:hidden shadow-sm z-30">
                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-blue-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <span class="text-lg font-bold text-slate-800 dark:text-white">AssetFlow</span>
                <div class="w-6"></div> {{-- Spacer --}}
            </header>

            {{-- Main Scrollable Area --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto">

                {{-- Jika ada header page spesifik --}}
                @if (isset($header))
                    <div class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700">
                        <div class="max-w-7xl mx-auto py-4 px-6">
                            {{ $header }}
                        </div>
                    </div>
                @endif

                {{-- Konten Livewire --}}
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>
            </main>
        </div>

        </div>
    </div>
@endsection