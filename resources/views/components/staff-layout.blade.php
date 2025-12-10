@extends('layouts.base')

@section('body')
    {{-- Custom Style untuk Background Dots --}}
    <style>
        /* Dark Mode Dots (Slate/Purple Hint) */
        @media(prefers-color-scheme: dark) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(148, 163, 184, 0.1)'/%3E%3C/svg%3E");
            }
        }

        /* Light Mode Dots (Blue Hint) */
        @media(prefers-color-scheme: light) {
            .bg-dots {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(37, 99, 235, 0.1)'/%3E%3C/svg%3E");
            }
        }
        [x-cloak] { display: none !important; }
    </style>

    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 selection:bg-indigo-500 selection:text-white font-sans text-slate-900 dark:text-slate-100">

        {{-- NAVIGATION BAR (Alpine.js) --}}
        <nav x-data="{ mobileMenuOpen: false, userDropdownOpen: false }"
             class="fixed top-0 z-50 w-full transition-colors duration-300 shadow-lg border-b border-blue-800 dark:border-slate-800 bg-blue-700 dark:bg-slate-900">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    {{-- KIRI: Logo & Desktop Menu --}}
                    <div class="flex items-center">
                        {{-- Logo --}}
                        <a href="{{ route('home') }}" class="shrink-0 flex items-center gap-2 group">
                            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                                <a href="{{ route('home') }}">
                                    <x-logo class="w-auto h-10 pb-0 mx-auto mb-0 text-indigo-600" />
                                </a>
                            </a>
                            <span class="text-xl font-bold text-blue-600 tracking-wide">
                                AssetFlow
                            </span>
                        </a>

                        {{-- Desktop Menu Links --}}
                        <div class="hidden sm:flex sm:items-center sm:ml-10 sm:space-x-4">

                            <a href="{{ route('home') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                               {{ request()->routeIs('home')
    ? 'bg-blue-800 text-white shadow-inner dark:bg-slate-800'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                                Dashboard
                            </a>

                            <a href="{{ route('staff.assets') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                               {{ request()->routeIs('staff.assets')
    ? 'bg-blue-800 text-white shadow-inner dark:bg-slate-800'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                                Katalog Aset
                            </a>

                            <a href="{{ route('staff.my-assets') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                               {{ request()->routeIs('staff.my-assets')
    ? 'bg-blue-800 text-white shadow-inner dark:bg-slate-800'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                                Aset Saya
                            </a>

                            <a href="{{ route('staff.report_damage') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150
                               {{ request()->routeIs('staff.report_damage')
    ? 'bg-blue-800 text-white shadow-inner dark:bg-slate-800'
    : 'text-blue-100 hover:bg-blue-600 hover:text-white dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white' }}">
                                Lapor Kerusakan
                            </a>

                        </div>
                    </div>

                    {{-- KANAN: User Profile & Mobile Toggle --}}
                    <div class="flex items-center">

                        {{-- User Dropdown (Desktop) --}}
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="relative" @click.away="userDropdownOpen = false">
                                <button @click="userDropdownOpen = !userDropdownOpen"
                                        class="flex items-center gap-2 max-w-xs text-sm rounded-full focus:outline-none transition-opacity hover:opacity-90">
                                    <span class="text-white font-medium text-sm mr-1 hidden md:block">{{ Auth::user()->name }}</span>

                                    <svg class="h-4 w-4 text-blue-200 transition-transform duration-200" :class="{'rotate-180': userDropdownOpen}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Dropdown Content --}}
                                <div x-show="userDropdownOpen"
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-xl bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 focus:outline-none py-1 z-50 divide-y divide-slate-100 dark:divide-slate-700">

                                    <div class="px-4 py-3">
                                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-bold">Signed in as</p>
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate" title="{{ Auth::user()->email }}">
                                            {{ Auth::user()->email }}
                                        </p>
                                    </div>

                                    <div class="py-1">
                                        <!-- Profile Link (Optional) -->
                                        {{-- <a href="#" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Profile</a> --}}

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                               class="group flex items-center px-4 py-2 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20">
                                                <svg class="mr-3 h-5 w-5 text-rose-400 group-hover:text-rose-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Sign Out
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Menu Button --}}
                        <div class="-mr-2 flex sm:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Open main menu</span>
                                <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MOBILE MENU --}}
            <div x-show="mobileMenuOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="sm:hidden bg-blue-800 dark:bg-slate-900 border-b border-blue-900 dark:border-slate-800 shadow-xl">

                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('staff.assets') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staff.assets') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        Katalog Aset
                    </a>
                    <a href="{{ route('staff.my-assets') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staff.my-assets') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        Aset Saya
                    </a>
                    <a href="{{ route('staff.report_damage') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staff.report_damage') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                        Lapor Kerusakan
                    </a>
                </div>

                {{-- Mobile User Profile --}}
                <div class="pt-4 pb-4 border-t border-blue-700 dark:border-slate-700">
                    <div class="flex items-center px-5">

                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-blue-200 mt-1">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-3 py-2 rounded-md text-base font-medium text-blue-100 hover:text-white hover:bg-blue-700">
                                Sign Out
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        {{-- MAIN CONTENT WRAPPER --}}
        <main class="pt-20 pb-10 min-h-screen bg-dots relative">
            {{-- Gradient Overlay untuk blend background dots dengan header --}}
            <div class="absolute top-0 left-0 w-full h-32 bg-linear-to-b from-slate-50 to-transparent dark:from-slate-900 pointer-events-none"></div>

            <div class="relative z-10 w-full">
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </main>

    </div>
@endsection