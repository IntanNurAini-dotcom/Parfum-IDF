<x-guest-layout>
    <div x-data="{ 
            password: '',
            password_confirmation: '',
            showPassword: false,
            showPasswordConfirm: false,
            submitting: false,
            get strengthScore() {
                let p = this.password;
                if (!p) return 0;
                let score = 0;
                if (p.length >= 8) score += 35;
                if (/[A-Z]/.test(p)) score += 20;
                if (/[0-9]/.test(p)) score += 20;
                if (/[^A-Za-z0-9]/.test(p)) score += 25;
                return Math.min(100, score);
            },
            get strengthLabel() {
                let s = this.strengthScore;
                if (s === 0) return '';
                if (s < 40) return 'Lemah';
                if (s < 75) return 'Sedang';
                return 'Kuat';
            },
            get strengthColor() {
                let s = this.strengthScore;
                if (s < 40) return 'bg-rose-500';
                if (s < 75) return 'bg-amber-500';
                return 'bg-emerald-500';
            }
        }" class="space-y-5">
        
        <!-- Header Title -->
        <div class="text-center space-y-1">
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#3B2A2E]">
                Atur Ulang Kata Sandi
            </h2>
            <p class="text-xs sm:text-sm text-[#3B2A2E]/70 font-medium">
                Masukkan kata sandi baru untuk akun Parfum IDF Anda.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" @submit="submitting = true" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="space-y-1">
                <label for="email" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Alamat Email
                </label>
                <div class="relative rounded-2xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </div>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email', $request->email) }}" 
                           required 
                           autofocus 
                           placeholder="nama@email.com"
                           class="w-full pl-11 pr-4 py-2.5 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                </div>
                @error('email')
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-circle-exclamation text-xs"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1">
                <label for="password" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Kata Sandi Baru
                </label>
                <div class="relative rounded-2xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           name="password" 
                           x-model="password"
                           required 
                           placeholder="Minimal 8 karakter"
                           class="w-full pl-11 pr-11 py-2.5 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#3B2A2E]/50 hover:text-[#B76E79] transition-colors">
                        <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                
                <!-- Password Strength Bar -->
                <div x-show="password.length > 0" x-transition class="pt-1 space-y-1">
                    <div class="flex items-center justify-between text-[10px] font-semibold text-[#3B2A2E]/70">
                        <span>Kekuatan kata sandi:</span>
                        <span x-text="strengthLabel" :class="strengthScore >= 75 ? 'text-emerald-700' : (strengthScore >= 40 ? 'text-amber-700' : 'text-rose-700')"></span>
                    </div>
                    <div class="w-full bg-gray-200/80 rounded-full h-1.5 overflow-hidden">
                        <div class="h-full transition-all duration-300 rounded-full" :class="strengthColor" :style="'width: ' + strengthScore + '%'"></div>
                    </div>
                </div>

                @error('password')
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-circle-exclamation text-xs"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="space-y-1">
                <label for="password_confirmation" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Konfirmasi Kata Sandi Baru
                </label>
                <div class="relative rounded-2xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-shield-halved text-sm"></i>
                    </div>
                    <input :type="showPasswordConfirm ? 'text' : 'password'" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           x-model="password_confirmation"
                           required 
                           placeholder="Ulangi kata sandi baru"
                           class="w-full pl-11 pr-11 py-2.5 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                    <button type="button" 
                            @click="showPasswordConfirm = !showPasswordConfirm" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#3B2A2E]/50 hover:text-[#B76E79] transition-colors">
                        <i class="fa-solid" :class="showPasswordConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>

                <!-- Live Password Match Indicator -->
                <div x-show="password_confirmation.length > 0" x-transition class="pt-0.5">
                    <template x-if="password === password_confirmation && password.length >= 8">
                        <p class="text-[11px] text-emerald-600 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-xs"></i>
                            <span>Kata sandi cocok!</span>
                        </p>
                    </template>
                    <template x-if="password !== password_confirmation">
                        <p class="text-[11px] text-rose-600 font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark text-xs"></i>
                            <span>Kata sandi belum sama.</span>
                        </p>
                    </template>
                </div>

                @error('password_confirmation')
                    <p class="text-xs text-rose-600 font-medium flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-circle-exclamation text-xs"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        :disabled="submitting" 
                        class="w-full py-3.5 px-6 rounded-2xl font-bold text-white text-xs sm:text-sm tracking-wider uppercase btn-rose-gold-shimmer flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                    <template x-if="submitting">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitting ? 'Memproses...' : 'Simpan Kata Sandi Baru'"></span>
                    <i x-show="!submitting" class="fa-solid fa-check text-xs"></i>
                </button>
            </div>
        </form>

        <div class="text-center pt-3 border-t border-[#B76E79]/15">
            <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-semibold text-[#B76E79] hover:text-[#C9A24D] transition-colors">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>
    </div>
</x-guest-layout>
