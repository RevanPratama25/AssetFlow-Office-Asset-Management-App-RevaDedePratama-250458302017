<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AssetFlow') }} - Manajemen Aset Kantor Modern</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Pastikan Tailwind sudah ter-build --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Animasi halus untuk gradient text */
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-move 3s ease infinite;
        }
        @keyframes gradient-move {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
    
    {{-- Script Toggle Dark Mode Sederhana (Opsional, bisa dihapus jika handle via sistem) --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="antialiased text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-900 selection:bg-blue-500 selection:text-white transition-colors duration-300">

    {{-- Background Decoration (Blurry Blobs) --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-indigo-100 dark:bg-indigo-900/20 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-sky-100 dark:bg-sky-900/20 rounded-full mix-blend-multiply dark:mix-blend-normal filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    {{-- Navbar Sticky & Glassy --}}
    <nav class="sticky top-0 z-50 w-full transition-all duration-300 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/60">
        <div class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            
            {{-- Logo --}}
            <a href="#" class="flex items-center gap-2 group">
                <div class="relative w-8 h-8 flex items-center justify-center bg-linear-to-br from-blue-600 to-indigo-600 rounded-lg text-white font-bold shadow-lg shadow-blue-500/30 transition-transform group-hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-800 dark:text-white">AssetFlow</span>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-300">
                <a href="#fitur" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Fitur</a>
                <a href="#keunggulan" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Keunggulan</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Hubungi Kami</a>
            </div>

            {{-- Auth Buttons --}}
            <div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/home') }}" class="font-semibold text-slate-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">Dashboard &rarr;</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:block font-semibold text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition px-4 py-2">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-full hover:bg-blue-600 dark:hover:bg-blue-500 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section class="relative pt-20 pb-32 overflow-hidden">
        <div class="px-6 max-w-7xl mx-auto text-center">
            
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 mb-8 px-4 py-1.5 rounded-full border border-blue-100 dark:border-blue-800 bg-blue-50/50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-semibold shadow-sm hover:bg-blue-100 dark:hover:bg-blue-900/50 transition cursor-default">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Sistem Manajemen Aset Terintegrasi v1.0
            </div>

            {{-- Headline --}}
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6 leading-tight">
                Kelola Aset Kantor dengan <br class="hidden lg:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 animate-gradient">
                    Cerdas & Efisien
                </span>
            </h1>

            {{-- Subheadline --}}
            <p class="text-lg sm:text-xl text-slate-500 dark:text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Tinggalkan spreadsheet manual. AssetFlow membantu perusahaan memantau stok, melacak peminjaman, dan menangani laporan kerusakan dalam satu dashboard modern.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
                @auth
                    <a href="{{ url('/home') }}" class="px-8 py-4 text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 rounded-xl shadow-xl shadow-blue-500/20 transition-all transform hover:-translate-y-1">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 text-lg font-bold text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 rounded-xl shadow-xl shadow-blue-500/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Coba Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    <a href="#fitur" class="px-8 py-4 text-lg font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 transition-all shadow-sm">
                        Pelajari Fitur
                    </a>
                @endauth
            </div>

            
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="fitur" class="py-24 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800">
        <div class="px-6 max-w-7xl mx-auto">
            <div class="text-center mb-16 max-w-3xl mx-auto">
                <h2 class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-2">Fitur Utama</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">Solusi Lengkap Siklus Aset</h3>
                <p class="text-slate-500 dark:text-slate-400 text-lg">Platform yang dirancang untuk memudahkan HR, IT, dan GA dalam mengelola inventaris perusahaan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Card 1 --}}
                <div class="group bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 dark:border-slate-700">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Manajemen Inventaris</h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                        Data aset terpusat dengan detail spesifikasi, kategori, dan lokasi. Lacak riwayat perbaikan dan nilai aset secara real-time.
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="group bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 dark:border-slate-700">
                    <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Sirkulasi Peminjaman</h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                        Staf dapat mengajukan peminjaman aset mandiri. Admin memverifikasi dengan satu klik. Sistem mencatat siapa memegang apa.
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="group bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 dark:border-slate-700">
                    <div class="w-14 h-14 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-xl flex items-center justify-center mb-6 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Maintenance Tracking</h3>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                        Fitur pelaporan kerusakan oleh staf dan pencatatan riwayat servis. Pantau biaya perawatan aset agar tetap efisien.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FOOTER --}}
    <section class="py-20 bg-slate-900 dark:bg-black text-white overflow-hidden relative border-t border-slate-800">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
        </div>
        <div class="px-6 max-w-4xl mx-auto text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6">Siap Mengoptimalkan Aset Anda?</h2>
            <p class="text-slate-300 text-lg mb-10">Bergabunglah sekarang dan rasakan kemudahan manajemen aset kantor yang modern dan transparan.</p>
            <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-lg rounded-full hover:bg-blue-50 dark:hover:bg-slate-700 transition shadow-lg transform hover:scale-105">
                Daftar Gratis Sekarang
            </a>
        </div>
    </section>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            {{-- Footer Brand & Logo --}}
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-slate-900 dark:bg-white rounded flex items-center justify-center text-white dark:text-slate-900 text-xs font-bold">A</div> 
                <span class="font-bold text-slate-800 dark:text-white">AssetFlow</span>
            </div>
            
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                &copy; {{ date('Y') }} AssetFlow. Dibuat untuk Efisiensi Kerja.
            </p>
            
            <div class="flex gap-6 text-sm text-slate-500 dark:text-slate-400 font-medium">
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Privacy</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Terms</a>
                <a href="#" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Support</a>
            </div>
        </div>
    </footer>
</body>
</html>