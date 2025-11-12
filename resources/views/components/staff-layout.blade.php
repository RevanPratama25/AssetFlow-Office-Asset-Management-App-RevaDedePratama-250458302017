@extends('layouts.base')

@section('body')
    {{-- Style asli untuk background dots tetap dipertahankan --}}
    <style>
        @media(prefers-color-scheme: dark) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(200,200,255,0.15)'/%3E%3C/svg%3E");
            }
        }

        @media(prefers-color-scheme: light) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,50,0.10)'/%3E%3C/svg%3E")
            }
        }
    </style>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 selection:bg-indigo-500 selection:text-white">

        {{-- NAVIGATION BAR START --}}
        <nav
            class="fixed top-0 z-50 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
            <div class="max-w-7xl my-auto mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    {{-- Kiri: Logo / Home Link (Opsional, bisa diisi nama aplikasi) --}}
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-blue-500 dark:from-blue-400 dark:to-indigo-400">
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                    </div>

                    {{-- Kanan: Menu Desktop --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('home') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-blue-400 transition duration-150 ease-in-out">
                                    Home
                                </a>

                                {{-- Dropdown Profil --}}
                                <div class="relative ml-3" id="user-dropdown-container rounded-full">
                                    <div>
                                        <button type="button" onclick="toggleDropdown()"
                                            class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-blue-500 dark:focus:ring-offset-gray-900 transition duration-150"
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <span
                                                class="px-3 py-2 rounded-full text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center transition">
                                                {{ Auth::user()->name }}
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    {{-- Isi Dropdown --}}
                                    <div id="user-dropdown-menu"
                                        class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50 transition-all duration-200 ease-out transform scale-95 opacity-0"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                        {{-- Tambahkan link profile jika ada --}}
                                        {{-- <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            role="menuitem">Your Profile</a> --}}
                                        <a :href="route('home')" :active="request()->routeIs('home')"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            role="menuitem">
                                            {{ __('Dashboard') }}
                                        </a>
                                        <a :href="route('staf.catalog')" :active="request()->routeIs('staf.catalog')"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            role="menuitem">
                                            {{ __('Katalog Aset') }}
                                        </a>
                                        <a :href="route('staf.my_assets')" :active="request()->routeIs('staf.my_assets')"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            role="menuitem">
                                            {{ __('Aset Saya') }}
                                        </a>
                                        <a :href="route('staf.report_damage')" :active="request()->routeIs('staf.report_damage')"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                                            role="menuitem">
                                            {{ __('Lapor Kerusakan') }}
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-blue-400"
                                                role="menuitem">
                                                Logout
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-blue-400 transition duration-150">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-blue-600 dark:hover:bg-blue-700 transition duration-150 shadow-sm">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>

                    {{-- Tombol Hamburger Mobile --}}
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" onclick="toggleMobileMenu()"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 dark:focus:ring-blue-500"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            {{-- Icon menu open --}}
                            <svg id="menu-icon-open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            {{-- Icon menu close --}}
                            <svg id="menu-icon-close" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Mobile (Muncul saat hamburger diklik) --}}
            <div class="hidden sm:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800"
                id="mobile-menu">
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-800">
                    @if (Route::has('login'))
                        @auth
                            <div class="flex items-center px-4">
                                <div class="flex-shrink-0">
                                    {{-- Placeholder Avatar --}}
                                    <div
                                        class="h-10 w-10 rounded-full bg-indigo-500 dark:bg-blue-600 flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-blue-300">
                                        {{ Auth::user()->email ?? '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a :href="route('home')" :active="request()->routeIs('home')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    {{ __('Dashboard') }}
                                </a>
                                <a :href="route('staf.catalog')" :active="request()->routeIs('staf.catalog') " class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    {{ __('Katalog Aset') }}
                                </a>
                                <a :href="route('staf.my_assets')" :active="request()->routeIs('staf.my_assets') " class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    {{ __('Aset Saya') }}
                                </a>
                                <a :href="route('staf.report_damage')" :active="request()->routeIs('staf.report_damage') " class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    {{ __('Lapor Kerusakan') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}" >
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        @else
                            <div class="mt-3 space-y-1 px-4">
                                <a href="{{ route('login') }}"
                                    class="block text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-blue-400 transition">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="block mt-2 text-base font-medium text-indigo-600 dark:text-blue-400 hover:text-indigo-800 dark:hover:text-blue-300 transition">Register</a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
        {{-- NAVIGATION BAR END --}}

        {{-- MAIN CONTENT WRAPPER --}}
        {{-- pt-16 ditambahkan agar konten tidak tertutup navbar yang fixed --}}
        <main class="pt-16 min-h-screen bg-dots flex flex-col justify-center items-center">
            <div class="w-full">
                @yield('content')

                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </main>

    </div>

    {{-- SCRIPT SEDERHANA UNTUK INTERAKSI NAVIGASI --}}
    <script>
        // Fungsi Toggle Dropdown Desktop
        function toggleDropdown() {
            const dropdown = document.getElementById('user-dropdown-menu');
            if (dropdown.classList.contains('hidden')) {
                // Show
                dropdown.classList.remove('hidden');
                setTimeout(() => {
                    dropdown.classList.remove('transform', 'scale-95', 'opacity-0');
                }, 10); // delay kecil untuk memicu transisi CSS
            } else {
                // Hide
                dropdown.classList.add('transform', 'scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 200); // sesuaikan dengan duration-200 di class CSS
            }
        }

        // Fungsi Toggle Menu Mobile
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const iconOpen = document.getElementById('menu-icon-open');
            const iconClose = document.getElementById('menu-icon-close');

            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        }

        // Menutup dropdown saat klik di luar area
        window.addEventListener('click', function (e) {
            const dropdownContainer = document.getElementById('user-dropdown-container');
            const dropdownMenu = document.getElementById('user-dropdown-menu');

            // Cek jika dropdown ada di halaman (hanya saat login)
            if (dropdownContainer && !dropdownContainer.contains(e.target)) {
                if (!dropdownMenu.classList.contains('hidden')) {
                    toggleDropdown();
                }
            }
        });
    </script>
@endsection