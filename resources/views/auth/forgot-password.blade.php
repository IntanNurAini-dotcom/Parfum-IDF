<x-guest-layout>
    <div x-data="{ submitting: false }" class="space-y-6">
        
        <!-- Header Title & Subtitle -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-[#B76E79] flex items-center justify-center mx-auto mb-2 text-xl shadow-xs">
                <i class="fa-solid fa-[#key] fa-key"></i>
            </div>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#3B2A2E]">
                Lupa Kata Sandi?
            </h2>
            <p class="text-xs sm:text-sm text-[#3B2A2E]/70 font-medium leading-relaxed max-w-sm mx-auto">
                Jangan khawatir! Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
            </p>
        </div>

        <!-- Session Status Alert -->
        @if (session('status'))
            <div class="bg-rose-50/90 border border-rose-200 text-rose-800 text-xs rounded-2xl p-3.5 flex items-start gap-2.5 shadow-xs animate-fade-in">
                <i class="fa-solid fa-paper-plane text-[#B76E79] text-base mt-0.5"></i>
                <span class="leading-relaxed">{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" @submit="submitting = true" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-[#3B2A2E] uppercase tracking-wider">
                    Alamat Email Terdaftar
                </label>
                <div class="relative rounded-2xl shadow-xs">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#B76E79]">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </div>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="nama@email.com"
                           class="w-full pl-11 pr-4 py-3 rounded-2xl text-xs sm:text-sm text-[#3B2A2E] placeholder-[#3B2A2E]/40 input-luxury">
                </div>
                @error('email')
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
                    <span x-text="submitting ? 'Mengirim...' : 'Kirim Tautan Reset Password'"></span>
                    <i x-show="!submitting" class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </div>
        </form>

        <!-- Footer Back Link -->
        <div class="text-center pt-3 border-t border-[#B76E79]/15">
            <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-semibold text-[#B76E79] hover:text-[#C9A24D] transition-colors">
                <i class="fa-solid fa-arrow-left mr-1.5"></i>
                <span>Kembali ke Halaman Masuk</span>
            </a>
        </div>
    </div>
</x-guest-layout>
