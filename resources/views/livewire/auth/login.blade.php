@section('title', 'AssetFlow Login')

<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-900 transition-colors duration-300 relative overflow-hidden">
    
    {{-- Background Decoration (Optional: Halus di belakang) --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-96 h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute top-[20%] -right-[10%] w-80 h-80 bg-indigo-100 dark:bg-indigo-900/20 rounded-full blur-3xl opacity-40"></div>
    </div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        {{-- CUSTOM LOGO ASSETFLOW --}}
        <div class="flex justify-center">
            <a href="{{ route('home') }}" class=" items-center gap-3 group">
                <div class="items-center">
                    <x-logo class="w-auto h-20 pb-0 mx-auto mb-0 text-indigo-450" />
                </div>
                <div class="justify-center">
                    <span class="text-3xl font-extrabold tracking-tight text-slate-800 dark:text-blue-600">AssetFlow</span>
                </div>
            </a>
        </div>

        <h2 class="mt-6 text-center text-2xl font-bold text-slate-900 dark:text-white">
            Selamat Datang Kembali
        </h2>
        
        @if (Route::has('register'))
            <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150">
                    Daftar sekarang
                </a>
            </p>
        @endif
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-white dark:bg-slate-800 py-8 px-4 shadow-2xl shadow-slate-200/50 dark:shadow-black/20 sm:rounded-2xl sm:px-10 border border-slate-100 dark:border-slate-700">
            
            <form wire:submit.prevent="authenticate" class="space-y-6">
                
                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Alamat Email
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input wire:model.lazy="email" id="email" name="email" type="email" required autofocus 
                            class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 sm:text-sm @error('email') border-rose-300 text-rose-900 placeholder-rose-300 focus:border-rose-300 focus:ring-rose-500 @enderror" 
                            placeholder="alamat@email.com" />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Password
                    </label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model.lazy="password" id="password" type="password" required 
                            class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl leading-5 bg-white dark:bg-slate-900 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 sm:text-sm @error('password') border-rose-300 text-rose-900 placeholder-rose-300 focus:border-rose-300 focus:ring-rose-500 @enderror" 
                            placeholder="••••••••" />
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model.lazy="remember" id="remember" type="checkbox" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer transition" />
                        <label for="remember" class="ml-2 block text-sm text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                            Ingat saya
                        </label>
                    </div>

                    {{-- <div class="text-sm leading-5">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition ease-in-out duration-150">
                            Lupa password?
                        </a>
                    </div> --}}
                </div>

                {{-- Submit Button --}}
                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/30 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring-4 focus:ring-blue-500/50 active:bg-blue-800 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                        Masuk
                    </button>
                </div>
            </form>

        </div>
        
        {{-- Footer Kecil --}}
        <p class="mt-8 text-center text-xs text-slate-400 dark:text-slate-500">
            &copy; {{ date('Y') }} AssetFlow Management System.
        </p>
    </div>
</div>