<x-guest-layout>
    <div x-data="{ 
            email: '{{ old('email') }}', 
            password: '', 
            submitting: false, 
            showPassword: false,
            openDemo: true
        }" class="space-y-5">
        
        <!-- Header Title -->
        <div class="text-center space-y-1">
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#3B2A2E]">
                Selamat Datang Kembali
            </h2>
            <p class="text-xs sm:text-sm text-[#3B2A2E]/70 font-medium">
                Masuk untuk melanjutkan perjalanan aromamu.
            </p>
        </div>

        <!-- Quick Demo Accounts Helper Card (Local / Debug mode only) -->
        @if (config('app.env') === 'local' || config('app.debug'))
            <div class="bg-amber-50/90 border border-amber-200/90 rounded-2xl p-3 text-xs text-[#3B2A2E] shadow-xs">
                <div class="flex items-center justify-between font-bold text-amber-950 mb-1.5">
                    <span class="flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
                        <i class="fa-solid fa-key text-[#C9A24D]"></i> Klik Akun Demo
                    </span>
                    <button type="button" @click="openDemo = !openDemo" class="text-[10px] text-amber-700 hover:text-amber-900 font-semibold underline focus:outline-none">
                        <span x-text="openDemo ? 'Sembunyikan' : 'Tampilkan'"></span>
                    </button>
                </div>
                
                <div x-show="openDemo" x-transition class="grid grid-cols-2 gap-2 text-[11px] pt-1">
                    <!-- Admin Auto-Fill Button -->
                    <button type="button" 
                            @click="email = 'admin@gmail.com'; password = 'admin12345'"
                            class="p-2.5 rounded-xl bg-white border border-amber-300/70 hover:border-amber-500 hover:bg-amber-100/40 text-left transition-all shadow-2xs group focus:outline-none cursor-pointer">
                        <div class="font-bold text-amber-950 flex items-center justify-between text-xs">
                            <span>👑 Admin</span>
                            <i class="fa-solid fa-bolt text-amber-500 text-[10px] group-hover:scale-125 transition-transform"></i>
                        </div>
                        <div class="text-[10px] font-mono text-amber-800/90 truncate mt-0.5">admin@gmail.com</div>
                        <div class="text-[9px] text-amber-700/60 font-semibold">pass: admin12345</div>
                    </button>

                    <!-- Pembeli Auto-Fill Button -->
                    <button type="button" 
                            @click="email = 'pembeli@gmail.com'; password = 'pembeli12345'"
                            class="p-2.5 rounded-xl bg-white border border-rose-300/70 hover:border-rose-500 hover:bg-rose-100/40 text-left transition-all shadow-2xs group focus:outline-none cursor-pointer">
                        <div class="font-bold text-rose-950 flex items-center justify-between text-xs">
                            <span>🛍️ Pembeli</span>
                            <i class="fa-solid fa-bolt text-rose-500 text-[10px] group-hover:scale-125 transition-transform"></i>
                        </div>
                        <div class="text-[10px] font-mono text-rose-800/90 truncate mt-0.5">pembeli@gmail.com</div>
                        <div class="text-[9px] text-rose-700/60 font-semibold">pass: pembeli12345</div>
                    </button>
                </div>
            </div>
        @endif

        <!-- Session Status Alert -->
        @if (session('status'))
            <div class="bg-rose-50/90 border border-rose-200 text-rose-800 text-xs rounded-2xl p-3.5 flex items-start gap-2.5 shadow-xs animate-fade-in">
                <i class="fa-solid fa-circle-check text-[#B76E79] text-base mt-0.5"></i>
                <span class="leading-relaxed">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" @submit="submitting = true" class="space-y-4">
            @csrf

            <!-- Email Address Field -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Alamat Email
                </label>
                <div class="relative rounded-2xl shadow-xs overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-11 flex items-center justify-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </div>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           x-model="email"
                           required 
                           autofocus 
                           placeholder="nama@email.com"
                           class="w-full h-11 pl-11 pr-4 py-2.5 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1.5 mt-1">
                        <i class="fa-solid fa-circle-exclamation text-xs"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                        Kata Sandi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#B76E79] hover:text-[#C9A24D] transition-colors">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                <div class="relative rounded-2xl shadow-xs overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-11 flex items-center justify-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           name="password" 
                           x-model="password"
                           required 
                           placeholder="••••••••"
                           class="w-full h-11 pl-11 pr-11 py-2.5 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 w-11 h-full flex items-center justify-center text-[#3B2A2E]/50 hover:text-[#B76E79] transition-colors focus:outline-none">
                        <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1.5 mt-1">
                        <i class="fa-solid fa-circle-exclamation text-xs"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Remember Me Checkbox (Fixed alignment) -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 rounded border-[#B76E79]/40 text-[#B76E79] shadow-2xs focus:ring-[#B76E79] focus:ring-offset-0 cursor-pointer shrink-0">
                    <span class="text-xs text-[#3B2A2E]/80 font-medium leading-none">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-1">
                <button type="submit" 
                        :disabled="submitting" 
                        class="w-full py-3.5 px-6 rounded-2xl font-bold text-white text-xs sm:text-sm tracking-wider uppercase btn-rose-gold-shimmer flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                    <template x-if="submitting">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitting ? 'Memproses...' : 'Masuk'"></span>
                    <i x-show="!submitting" class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </form>

        <!-- Footer Call to Action -->
        <div class="text-center pt-3 border-t border-[#B76E79]/15">
            <p class="text-xs text-[#3B2A2E]/70 font-medium">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-[#B76E79] hover:text-[#C9A24D] transition-colors underline">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
