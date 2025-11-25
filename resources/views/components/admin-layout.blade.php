@extends('layouts.base')

@section('body')
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 dark:bg-gray-900 flex overflow-hidden">

        {{-- OVERLAY UNTUK MOBILE (Menutup sidebar saat diklik di luar area sidebar) --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden transition-opacity duration-300 ease-linear"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        {{-- SIDEBAR --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-50 inset-y-0 left-0 w-64 transition duration-300 transform bg-white dark:bg-gray-800 md:relative md:translate-x-0 flex flex-col shadow-lg md:shadow-none border-r border-gray-200 dark:border-gray-700">
            {{-- HEADER SIDEBAR (Logo/Brand) --}}
            <div class="flex items-center justify-between h-16 px-4 bg-indigo-600 dark:bg-gray-900 md:flex-shrink-0">
                <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-blue-500 dark:from-blue-400 dark:to-indigo-400">
                    AssetFlow Admin
                </span>
                {{-- Tombol tutup sidebar (hanya di mobile) --}}
                <button @click="sidebarOpen = false" class="md:hidden text-white focus:outline-none hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- KONTEN NAVIGASI SIDEBAR --}}
            <div class="flex flex-col flex-1 overflow-y-auto">
                <nav class="flex-1 px-2 py-4 space-y-1">

                    {{-- Dashboard Link --}}
                    <a href="{{ route('admin.overview') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.dashboard')
    ? 'bg-indigo-100 text-indigo-700 dark:bg-gray-700 dark:text-indigo-400'
    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.users.index')
    ? 'bg-indigo-100 text-indigo-700 dark:bg-gray-700 dark:text-indigo-400'
    : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                        <svg class="mr-3 h-5 w-5 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4H1m3 4H1m3 4H1m3 4H1m6.071.286a3.429 3.429 0 1 1 6.858 0M4 1h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Zm9 6.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                        </svg>
                        Manajemen Pengguna
                    </a>

                    {{-- Manajemen Aset Group --}}
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-gray-500">
                            Manajemen Aset
                        </p>
                    </div>
                    <div class="space-y-1">
                        {{-- Contoh penggunaan component link atau manual seperti di atas --}}
                        <a href="{{ route('admin.assets.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Data Aset
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                           <svg class="mr-3 h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Kategori
                        </a>
                         <a href="{{ route('admin.locations.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Lokasi
                        </a>
                    </div>

                    {{-- Pemakaian Aset Group --}}
                    <div class="pt-4 pb-1">
                         <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-gray-500">
                            Pemakaian Aset
                        </p>
                    </div>
                    <div class="space-y-1">
                         <a href="{{ route('admin.admin.borrowings') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Pengajuan Baru
                        </a>
                        <a href="{{ route('admin.admin.returns') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Verifikasi Pengembalian
                        </a>
                    </div>

                    {{-- Laporan Group --}}
                    <div class="pt-4 pb-1">
                        <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-gray-500">
                            Laporan
                        </p>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('admin.admin.maintenance') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Laporan Kerusakan
                        </a>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('admin.reports.borrowing') }}"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            Laporan Pemakaian
                        </a>
                    </div>
                </nav>

                {{-- FOOTER SIDEBAR (Logout) --}}
                <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- TOP NAVBAR (Mobile only toggle & User Info) --}}
            <header class="flex items-center justify-between h-16 px-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sm:px-6 lg:px-8 md:hidden">
                {{-- Tombol Hamburger Mobile --}}
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none focus:text-gray-700 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 md:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                 {{-- Logo/Brand di Mobile (Optional) --}}
                 <div class="md:hidden text-lg font-bold text-gray-900 dark:text-white">
                    AssetFlow
                </div>
                 {{-- Kosongkan kanan untuk keseimbangan atau tambah menu profil kecil --}}
                <div class="w-6 md:hidden"></div>
            </header>

            {{-- HEADER HALAMAN--}}
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow-sm z-10">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                         {{ $header }}
                    </div>
                </header>
            @endif

            {{-- KONTEN UTAMA --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-8">
                     @yield('content')

                     @isset($slot)
                        {{ $slot }}
                    @endisset
                </div>
            </main>
        </div>

    </div>
@endsection