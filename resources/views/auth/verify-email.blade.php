<x-guest-layout>
    <div x-data="{ submitting: false }" class="space-y-6">
        
        <!-- Header Title & Subtitle -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-[#B76E79] flex items-center justify-center mx-auto mb-2 text-xl shadow-xs">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-[#3B2A2E]">
                Verifikasi Alamat Email
            </h2>
            <p class="text-xs sm:text-sm text-[#3B2A2E]/70 font-medium leading-relaxed max-w-sm mx-auto">
                Terima kasih telah mendaftar di Parfum IDF! Sebelum memulai, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-emerald-50/90 border border-emerald-200 text-emerald-800 text-xs rounded-2xl p-3.5 flex items-start gap-2.5 shadow-xs animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5"></i>
                <span class="leading-relaxed">
                    Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda berikan saat pendaftaran.
                </span>
            </div>
        @endif

        <div class="space-y-3 pt-2">
            <form method="POST" action="{{ route('verification.send') }}" @submit="submitting = true">
                @csrf
                <button type="submit" 
                        :disabled="submitting" 
                        class="w-full py-3.5 px-6 rounded-2xl font-bold text-white text-xs sm:text-sm tracking-wider uppercase btn-rose-gold-shimmer flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                    <template x-if="submitting">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <span x-text="submitting ? 'Mengirim...' : 'Kirim Ulang Email Verifikasi'"></span>
                    <i x-show="!submitting" class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center pt-2">
                @csrf
                <button type="submit" class="text-xs font-semibold text-[#B76E79] hover:text-[#C9A24D] transition-colors underline">
                    Keluar Akun
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
