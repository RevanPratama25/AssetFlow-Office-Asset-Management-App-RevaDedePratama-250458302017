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
        [x-cloak] { display: none !important; }
    </style>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 selection:bg-blue-500 selection:text-white">

        {{-- NAVIGATION BAR START (Dikelola oleh Alpine.js) --}}
        <nav x-data="{ mobileMenuOpen: false }"
            class="fixed top-0 z-50 w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
            <div class="max-w-7xl my-auto mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    {{-- Kiri: Logo / Home Link --}}
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center group">
                            <span
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-400 dark:to-blue-500 group-hover:opacity-80 transition-opacity">
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                    </div>

                    {{-- Kanan: Menu Desktop --}}
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('home') }}"
                                    class="flex items-center text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400' }} transition duration-150 ease-in-out">
                                    <svg class="w-5 h-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    Home
                                </a>

                                {{-- Dropdown Profil (Alpine.js) --}}
                                <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                                    <div>
                                        <button type="button" @click="dropdownOpen = !dropdownOpen"
                                            class="flex items-center max-w-xs text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 transition duration-150"
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <span class="sr-only">Open user menu</span>
                                            <span
                                                class="px-3 py-2 rounded-full text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center transition">
                                                {{ Auth::user()->name }}
                                                <svg class="ml-2 -mr-0.5 h-4 w-4 transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    {{-- Isi Dropdown (Dengan Animasi) --}}
                                    <div x-show="dropdownOpen"
                                         x-cloak
                                         @click.away="dropdownOpen = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                        
                                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Masuk sebagai</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ Auth::user()->email }}">
                                                {{ Auth::user()->email }}
                                            </p>
                                        </div>

                                        <div class="py-1" role="none">
                                            <a href="{{ route('home') }}"
                                               class="flex items-center px-4 py-2 text-sm {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700"
                                               role="menuitem">
                                                <svg class="w-5 h-5 mr-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                                </svg>
                                                {{ __('Dashboard') }}
                                            </a>
                                            <a href="{{ route('staff.assets') }}"
                                               class="flex items-center px-4 py-2 text-sm {{ request()->routeIs('staf.catalog') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700"
                                               role="menuitem">
                                                <svg class="w-5 h-5 mr-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                  <path d="M3.5 3.75a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v12.5a.25.25 0 01-.25.25H3.75a.25.25 0 01-.25-.25V3.75zM5 5v10h10V5H5zM6.25 6.25a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5zM6.25 9.25a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5zM6.25 12.25a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5z" />
                                                </svg>
                                                {{ __('Katalog Aset') }}
                                            </a>
                                            <a href="{{ route('staff.my-assets')}}"
                                               class="flex items-center px-4 py-2 text-sm {{ request()->routeIs('staf.my_assets') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700"
                                               role="menuitem">
                                                <svg class="w-5 h-5 mr-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                  <path d="M2.913 2.913a.75.75 0 011.06 0L8 6.94l4.028-4.027a.75.75 0 011.06 0l4.028 4.027v-1.1a.75.75 0 011.5 0v3.379a.75.75 0 01-.22.53l-4.25 4.25a.75.75 0 01-1.06 0L10 9.719l-4.25 4.25a.75.75 0 01-1.06 0l-4.25-4.25a.75.75 0 01-.22-.53V5.81a.75.75 0 011.5 0v1.1L2.913 2.913zM6.94 8l-4.028 4.028v1.1a.75.75 0 00.22.53l4.25 4.25a.75.75 0 001.06 0L10 16.281l4.25 4.25a.75.75 0 001.06 0l4.25-4.25a.75.75 0 00.22-.53v-1.1L13.06 8l4.028-4.028a.75.75 0 00-1.06-1.06L12 6.94 7.972 2.913a.75.75 0 00-1.06 0L2.913 6.94l4.027 4.028z" />
                                                </svg>
                                                {{ __('Aset Saya') }}
                                            </a>
                                            <a href="{{ route('staff.report_damage')}}"
                                               class="flex items-center px-4 py-2 text-sm {{ request()->routeIs('staf.report_damage') ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} hover:bg-gray-100 dark:hover:bg-gray-700"
                                               role="menuitem">
                                                <svg class="w-5 h-5 mr-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                </svg>
                                                {{ __('Lapor Kerusakan') }}
                                            </a>
                                        </div>
                                        <div class="py-1 border-t border-gray-100 dark:border-gray-700" role="none">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-red-400"
                                                   role="menuitem">
                                                    <svg class="w-5 h-5 mr-2.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25zM10.75 8.75a.75.75 0 000 1.5h5.5a.75.75 0 000-1.5h-5.5zM16 10a.75.75 0 01.75-.75h.25a.75.75 0 010 1.5h-.25A.75.75 0 0116 10z" clip-rule="evenodd" />
                                                      <path fill-rule="evenodd" d="M16.47 7.53a.75.75 0 011.06 0l2 2a.75.75 0 010 1.06l-2 2a.75.75 0 11-1.06-1.06L17.19 10 16.47 9.06a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                    </svg>
                                                    Logout
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition duration-150">
                                     <svg class="w-5 h-5 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 3.75a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5a.75.75 0 01.75-.75zM4.155 5.272a.75.75 0 01.166-.026h.002c.038 0 .076.002.113.006.082.008.164.02.242.036.16.032.316.078.46.138.14.058.27.13.389.215.118.084.225.18.318.286.09.103.165.213.226.33a.75.75 0 01-1.309.75A1.19 1.19 0 005 6.363A1.19 1.19 0 003.75 7.5v6A1.19 1.19 0 005 14.637a1.19 1.19 0 001.25-1.137.75.75 0 011.309.75c-.06.117-.135.227-.226.33a2.692 2.692 0 01-.318.286c-.119.085-.248.157-.389.215-.144.06-.3.106-.46.138a4.42 4.42 0 01-.355.042c-.038.003-.075.005-.113.006h-.002a.75.75 0 01-.166-.026A2.75 2.75 0 012 13.5V7.5a2.75 2.75 0 012.155-2.228z" clip-rule="evenodd" />
                                    </svg>
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 shadow-sm">
                                        <svg class="w-5 h-5 mr-1.5 -ml-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M5.433 4.364l4.21 3.508 4.21-3.508a.75.75 0 11.914 1.173l-4.21 3.508 4.21 3.508a.75.75 0 11-.914 1.173l-4.21-3.508-4.21 3.508a.75.75 0 11-.914-1.173l4.21-3.508-4.21-3.508a.75.75 0 01.914-1.173z" />
                                          <path d="M10 8a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 8z" />
                                        </svg>
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>

                    {{-- Tombol Hamburger Mobile --}}
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 "
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            {{-- Icon menu open --}}
                            <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            {{-- Icon menu close --}}
                            <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Menu Mobile (Dengan Animasi) --}}
            <div x-show="mobileMenuOpen"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="sm:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-800">
                    @if (Route::has('login'))
                        @auth
                            <div class="flex items-center px-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full bg-blue-500 dark:bg-blue-600 flex items-center justify-center text-white font-bold">
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
                                <a href="{{ route('home') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    {{ __('Dashboard') }}
                                </a>
                                <a href="{{ route('staff.assets') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staf.catalog') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path d="M3.5 3.75a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v12.5a.25.25 0 01-.25.25H3.75a.25.25 0 01-.25-.25V3.75zM5 5v10h10V5H5zM6.25 6.25a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5zM6.25 9.25a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5zM6.25 12.25a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5z" />
                                    </svg>
                                    {{ __('Katalog Aset') }}
                                </a>
                                <a href="{{ route('staff.my-assets') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staf.my_assets') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path d="M2.913 2.913a.75.75 0 011.06 0L8 6.94l4.028-4.027a.75.75 0 011.06 0l4.028 4.027v-1.1a.75.75 0 011.5 0v3.379a.75.75 0 01-.22.53l-4.25 4.25a.75.75 0 01-1.06 0L10 9.719l-4.25 4.25a.75.75 0 01-1.06 0l-4.25-4.25a.75.75 0 01-.22-.53V5.81a.75.75 0 011.5 0v1.1L2.913 2.913zM6.94 8l-4.028 4.028v1.1a.75.75 0 00.22.53l4.25 4.25a.75.75 0 001.06 0L10 16.281l4.25 4.25a.75.75 0 001.06 0l4.25-4.25a.75.75 0 00.22-.53v-1.1L13.06 8l4.028-4.028a.75.75 0 00-1.06-1.06L12 6.94 7.972 2.913a.75.75 0 00-1.06 0L2.913 6.94l4.027 4.028z" />
                                    </svg>
                                    {{ __('Aset Saya') }}
                                </a>
                                <a href="{{ route('staff.report_damage') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('staf.report_damage') ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400' }} hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Lapor Kerusakan') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25zM10.75 8.75a.75.75 0 000 1.5h5.5a.75.75 0 000-1.5h-5.5zM16 10a.75.75 0 01.75-.75h.25a.75.75 0 010 1.5h-.25A.75.75 0 0116 10z" clip-rule="evenodd" />
                                          <path fill-rule="evenodd" d="M16.47 7.53a.75.75 0 011.06 0l2 2a.75.75 0 010 1.06l-2 2a.75.75 0 11-1.06-1.06L17.19 10 16.47 9.06a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        </svg>
                                        Logout
                                    </a>
                                </form>
                            </div>
                        @else
                            <div class="mt-3 space-y-1 px-4">
                                <a href="{{ route('login') }}"
                                    class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-blue-400 transition">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 3.75a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5a.75.75 0 01.75-.75zM4.155 5.272a.75.75 0 01.166-.026h.002c.038 0 .076.002.113.006.082.008.164.02.242.036.16.032.316.078.46.138.14.058.27.13.389.215.118.084.225.18.318.286.09.103.165.213.226.33a.75.75 0 01-1.309.75A1.19 1.19 0 005 6.363A1.19 1.19 0 003.75 7.5v6A1.19 1.19 0 005 14.637a1.19 1.19 0 001.25-1.137.75.75 0 011.309.75c-.06.117-.135.227-.226.33a2.692 2.692 0 01-.318.286c-.119.085-.248.157-.389.215-.144.06-.3.106-.46.138a4.42 4.42 0 01-.355.042c-.038.003-.075.005-.113.006h-.002a.75.75 0 01-.166-.026A2.75 2.75 0 012 13.5V7.5a2.75 2.75 0 012.155-2.228z" clip-rule="evenodd" />
                                    </svg>
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="flex items-center px-3 py-2 rounded-md text-base font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                                        <svg class="w-5 h-5 mr-3 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M5.433 4.364l4.21 3.508 4.21-3.508a.75.75 0 11.914 1.173l-4.21 3.508 4.21 3.508a.75.75 0 11-.914 1.173l-4.21-3.508-4.21 3.508a.75.75 0 11-.914-1.173l4.21-3.508-4.21-3.508a.75.75 0 01.914-1.173z" />
                                          <path d="M10 8a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 8z" />
                                        </svg>
                                        Register
                                    </a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
        {{-- NAVIGATION BAR END --}}

        {{-- MAIN CONTENT WRAPPER --}}
        <main class="pt-16 min-h-screen bg-dots flex flex-col justify-center items-center">
            <div class="w-full">
                @yield('content')

                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </main>

    </div>

@endsection