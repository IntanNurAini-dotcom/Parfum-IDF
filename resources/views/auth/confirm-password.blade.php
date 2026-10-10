<x-guest-layout>
    <div x-data="{ submitting: false, showPassword: false }" class="space-y-6">
        
        <!-- Header Title & Subtitle -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-[#B76E79] flex items-center justify-center mx-auto mb-2 text-xl shadow-xs">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#3B2A2E]">
                Konfirmasi Kata Sandi
            </h2>
            <p class="text-xs sm:text-sm text-[#3B2A2E]/70 font-medium leading-relaxed max-w-sm mx-auto">
                Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" @submit="submitting = true" class="space-y-5">
            @csrf

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Kata Sandi
                </label>
                <div class="relative rounded-2xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           name="password" 
                           required 
                           placeholder="••••••••"
                           class="w-full pl-11 pr-11 py-3 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#3B2A2E]/50 hover:text-[#B76E79] transition-colors">
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
                    <span x-text="submitting ? 'Memproses...' : 'Konfirmasi Kata Sandi'"></span>
                    <i x-show="!submitting" class="fa-solid fa-check text-xs"></i>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
