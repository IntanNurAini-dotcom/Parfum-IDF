@extends('layouts.app')

@section('content')
<div class="py-10 bg-[#FDF8F5] min-h-screen" 
     x-data="{ 
        isPaid: {{ $order->isPaid() ? 'true' : 'false' }},
        isExpired: {{ $order->isExpired() ? 'true' : 'false' }},
        copiedField: null,
        hours: '00',
        minutes: '00',
        seconds: '00',
        expiryTime: {{ $order->payment_expired_at ? $order->payment_expired_at->timestamp * 1000 : 'null' }},
        
        init() {
            this.updateCountdown();
            setInterval(() => this.updateCountdown(), 1000);
            
            if (!this.isPaid && !this.isExpired) {
                setInterval(() => this.pollStatus(), 5000);
            }
        },

        updateCountdown() {
            if (!this.expiryTime) return;
            const now = new Date().getTime();
            const distance = this.expiryTime - now;

            if (distance < 0) {
                this.hours = '00';
                this.minutes = '00';
                this.seconds = '00';
                this.isExpired = true;
                return;
            }

            const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((distance % (1000 * 60)) / 1000);

            this.hours = h < 10 ? '0' + h : h;
            this.minutes = m < 10 ? '0' + m : m;
            this.seconds = s < 10 ? '0' + s : s;
        },

        copyToClipboard(text, fieldName) {
            navigator.clipboard.writeText(text);
            this.copiedField = fieldName;
            setTimeout(() => { this.copiedField = null; }, 2500);
        },

        pollStatus() {
            fetch('{{ route('orders.check_status', $order->id) }}')
                .then(res => res.json())
                .then(data => {
                    if (data.is_paid) {
                        this.isPaid = true;
                    }
                    if (data.is_expired) {
                        this.isExpired = true;
                    }
                })
                .catch(err => console.error(err));
        }
     }">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- LUXURY SUCCESS OVERLAY SCREEN WHEN PAID -->
        <div x-show="isPaid" x-transition class="bg-white rounded-3xl p-8 border border-amber-300 shadow-2xl text-center space-y-6 my-6">
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto text-emerald-600 text-3xl shadow-md animate-bounce">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="space-y-2">
                <span class="text-xs font-bold tracking-widest text-amber-600 uppercase">✦ PARFUM IDF LUXURY ✦</span>
                <h2 class="font-serif-luxury text-3xl font-bold text-gray-900">Pembayaran Berhasil!</h2>
                <p class="text-sm text-gray-600 max-w-md mx-auto">
                    Terima kasih! Pembayaran Anda telah kami terima. Pesanan Anda saat ini sedang disiapkan oleh tim perfumer profesional Parfum IDF.
                </p>
            </div>

            <div class="bg-amber-50/60 rounded-2xl p-4 max-w-md mx-auto border border-amber-200 text-left text-xs space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor Pesanan:</span>
                    <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode Pembayaran:</span>
                    <span class="font-semibold text-amber-800">{{ $order->formatted_payment_type }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Total Pembayaran:</span>
                    <span class="font-bold text-emerald-600 text-sm">{{ $order->formatted_grand_total }}</span>
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('orders.show', $order->id) }}" class="px-6 py-3 rounded-full bg-pink-gold-gradient text-white text-xs font-bold shadow-md hover:scale-105 transition-transform">
                    <i class="fa-solid fa-box mr-2"></i> Lihat Rincian Pesanan
                </a>
                <a href="{{ route('catalog.index') }}" class="px-6 py-3 rounded-full bg-gray-100 text-gray-700 text-xs font-bold hover:bg-gray-200 transition-colors">
                    Lanjut Belanja
                </a>
            </div>
        </div>

        <!-- MAIN PAYMENT DETAIL CONTAINER (WHILE UNPAID / EXPIRED) -->
        <div x-show="!isPaid" class="space-y-6">

            <!-- Top Header Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-pink-gold-gradient"></div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-100 pb-6">
                    <div>
                        <span class="text-[10px] font-bold tracking-widest text-pink-600 uppercase block mb-1">HAUTE PARFUMERIE</span>
                        <h1 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-gray-900">
                            Pembayaran Pesanan
                        </h1>
                        <p class="text-xs text-gray-500 mt-1">
                            Kode Pesanan: <span class="font-mono font-bold text-gray-800">{{ $order->order_number }}</span>
                        </p>
                    </div>

                    <!-- Status Badge -->
                    <template x-if="isExpired">
                        <span class="px-4 py-2 rounded-full bg-rose-100 text-rose-800 border border-rose-300 text-xs font-bold flex items-center gap-2">
                            <i class="fa-solid fa-circle-xmark"></i> Kedaluwarsa / Dibatalkan
                        </span>
                    </template>
                    <template x-if="!isExpired">
                        <span class="px-4 py-2 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-bold flex items-center gap-2">
                            <i class="fa-solid fa-clock text-amber-600 animate-spin"></i> Menunggu Pembayaran
                        </span>
                    </template>
                </div>

                <!-- Countdown Timer Section -->
                <div x-show="!isExpired" class="mt-6 bg-pink-50/60 rounded-2xl p-4 border border-pink-200/60 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="flex items-center gap-3 text-xs text-pink-950 font-medium">
                        <div class="w-9 h-9 rounded-full bg-rose-gold text-white flex items-center justify-center font-bold">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div>
                            <p class="font-bold">Batas Waktu Pembayaran</p>
                            <p class="text-[11px] text-pink-700">Selesaikan sebelum batas waktu berakhir untuk menghindari pembatalan otomatis.</p>
                        </div>
                    </div>

                    <!-- Countdown Digital Clock -->
                    <div class="flex items-center gap-2 font-mono text-sm font-bold text-pink-900 bg-white px-4 py-2 rounded-xl border border-pink-200 shadow-xs">
                        <span x-text="hours">00</span>:
                        <span x-text="minutes">00</span>:
                        <span x-text="seconds">00</span>
                    </div>
                </div>
            </div>

            <!-- EXPIRED STATE NOTICE -->
            <div x-show="isExpired" class="bg-rose-50 border border-rose-200 rounded-3xl p-6 text-center space-y-3">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-3xl"></i>
                <h3 class="font-serif-luxury font-bold text-lg text-rose-900">Batas Waktu Pembayaran Telah Berakhir</h3>
                <p class="text-xs text-rose-700 max-w-md mx-auto">
                    Pesanan ini telah dibatalkan secara otomatis karena melewati batas waktu 24 jam. Stok produk telah dikembalikan.
                </p>
                <div class="pt-2">
                    <a href="{{ route('catalog.index') }}" class="px-5 py-2.5 rounded-full bg-rose-600 text-white text-xs font-bold hover:bg-rose-700 transition-colors">
                        Belanja Kembali
                    </a>
                </div>
            </div>

            <!-- PAYMENT INSTRUCTIONS BASED ON METHOD SELECTED -->
            <div x-show="!isExpired" class="space-y-6">

                <!-- 1. VIRTUAL ACCOUNT METHOD -->
                @if(in_array($order->payment_type, ['bank_transfer', 'echannel', 'permata']) || $order->va_number)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-base">Virtual Account {{ strtoupper($order->payment_bank ?? 'Bank') }}</h3>
                                    <p class="text-xs text-gray-500">Bayar melalui ATM, M-Banking, atau Internet Banking</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold uppercase px-3 py-1 bg-amber-100 text-amber-800 rounded-full">
                                {{ strtoupper($order->payment_bank ?? 'VA') }}
                            </span>
                        </div>

                        <!-- VA Number Box -->
                        <div class="bg-pink-50/50 rounded-2xl p-5 border border-pink-200/80 space-y-2">
                            <span class="text-xs text-gray-500 font-medium block">Nomor Virtual Account:</span>
                            <div class="flex items-center justify-between gap-4">
                                <span class="font-mono text-xl sm:text-2xl font-bold tracking-wider text-pink-950">
                                    {{ $order->va_number }}
                                </span>
                                <button type="button" 
                                        @click="copyToClipboard('{{ str_replace(' ', '', $order->va_number) }}', 'va')"
                                        class="px-4 py-2 rounded-xl bg-white border border-pink-300 text-pink-700 hover:bg-pink-100 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-regular fa-copy"></i>
                                    <span x-text="copiedField === 'va' ? 'Tersalin!' : 'Salin VA'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Amount Box -->
                        <div class="bg-amber-50/50 rounded-2xl p-5 border border-amber-200/80 space-y-2">
                            <span class="text-xs text-gray-500 font-medium block">Total Pembayaran:</span>
                            <div class="flex items-center justify-between gap-4">
                                <span class="font-serif-luxury text-2xl sm:text-3xl font-bold text-amber-900">
                                    {{ $order->formatted_grand_total }}
                                </span>
                                <button type="button" 
                                        @click="copyToClipboard('{{ (int)$order->grand_total }}', 'amount')"
                                        class="px-4 py-2 rounded-xl bg-white border border-amber-300 text-amber-800 hover:bg-amber-100 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-regular fa-copy"></i>
                                    <span x-text="copiedField === 'amount' ? 'Tersalin!' : 'Salin Nominal'"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Step Accordions -->
                        <div x-data="{ activeStep: 'm-banking' }" class="space-y-3 pt-2">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-gray-700">Petunjuk Pembayaran:</h4>
                            
                            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                                <button type="button" @click="activeStep = activeStep === 'm-banking' ? null : 'm-banking'"
                                        class="w-full px-4 py-3 bg-gray-50 hover:bg-gray-100 flex justify-between items-center text-xs font-bold text-gray-800">
                                    <span><i class="fa-solid fa-mobile-screen mr-2 text-pink-600"></i> Via Mobile Banking (m-Banking)</span>
                                    <i class="fa-solid" :class="activeStep === 'm-banking' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeStep === 'm-banking'" x-transition class="p-4 text-xs text-gray-600 space-y-2 bg-white">
                                    <ol class="list-decimal list-inside space-y-1.5 leading-relaxed">
                                        <li>Buka aplikasi Mobile Banking bank Anda (BCA Mobile, Livin by Mandiri, BRImo, BNI Mobile, dll).</li>
                                        <li>Pilih menu <strong>Transfer</strong> &gt; <strong>Virtual Account / BayarTagihan</strong>.</li>
                                        <li>Masukkan nomor Virtual Account: <strong class="font-mono text-pink-700">{{ $order->va_number }}</strong>.</li>
                                        <li>Periksa konfirmasi detail pesanan dan nominal <strong class="text-pink-700">{{ $order->formatted_grand_total }}</strong>.</li>
                                        <li>Masukkan PIN M-Banking Anda untuk menyelesaikan transaksi.</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                                <button type="button" @click="activeStep = activeStep === 'atm' ? null : 'atm'"
                                        class="w-full px-4 py-3 bg-gray-50 hover:bg-gray-100 flex justify-between items-center text-xs font-bold text-gray-800">
                                    <span><i class="fa-solid fa-credit-card mr-2 text-pink-600"></i> Via ATM</span>
                                    <i class="fa-solid" :class="activeStep === 'atm' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeStep === 'atm'" x-transition class="p-4 text-xs text-gray-600 space-y-2 bg-white">
                                    <ol class="list-decimal list-inside space-y-1.5 leading-relaxed">
                                        <li>Masukkan kartu ATM dan PIN Anda di mesin ATM terdekat.</li>
                                        <li>Pilih menu <strong>Transaksi Lainnya</strong> &gt; <strong>Transfer / Pembayaran</strong> &gt; <strong>Ke Rekening Virtual Account</strong>.</li>
                                        <li>Masukkan nomor Virtual Account: <strong class="font-mono text-pink-700">{{ $order->va_number }}</strong>.</li>
                                        <li>Konfirmasi detail tagihan dan ikuti petunjuk layar hingga selesai.</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-2xl overflow-hidden">
                                <button type="button" @click="activeStep = activeStep === 'internet' ? null : 'internet'"
                                        class="w-full px-4 py-3 bg-gray-50 hover:bg-gray-100 flex justify-between items-center text-xs font-bold text-gray-800">
                                    <span><i class="fa-solid fa-laptop mr-2 text-pink-600"></i> Via Internet Banking</span>
                                    <i class="fa-solid" :class="activeStep === 'internet' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                </button>
                                <div x-show="activeStep === 'internet'" x-transition class="p-4 text-xs text-gray-600 space-y-2 bg-white">
                                    <ol class="list-decimal list-inside space-y-1.5 leading-relaxed">
                                        <li>Login ke situs Internet Banking bank Anda.</li>
                                        <li>Pilih menu <strong>Bayar Tagihan / Transfer Virtual Account</strong>.</li>
                                        <li>Masukkan nomor Virtual Account: <strong class="font-mono text-pink-700">{{ $order->va_number }}</strong>.</li>
                                        <li>Verifikasi nominal tagihan <strong class="text-pink-700">{{ $order->formatted_grand_total }}</strong> dan otorisasi transaksi dengan token/OTP Anda.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- 2. QRIS METHOD -->
                @elseif($order->payment_type === 'qris' || $order->payment_qr_url)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6 text-center">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-pink-600">SCAN & PAY QRIS</span>
                            <h3 class="font-serif-luxury text-2xl font-bold text-gray-900">Pembayaran QRIS Universal</h3>
                            <p class="text-xs text-gray-500">Scan QRIS menggunakan GoPay, OVO, Dana, LinkAja, ShopeePay, atau aplikasi M-Banking apapun.</p>
                        </div>

                        <!-- QR Image Container -->
                        <div class="bg-pink-50/50 p-6 rounded-3xl border border-pink-200 inline-block max-w-xs mx-auto shadow-md">
                            @if($order->payment_qr_url)
                                <img src="{{ $order->payment_qr_url }}" alt="QRIS Code" class="w-56 h-56 mx-auto rounded-xl shadow-xs">
                            @else
                                <div class="w-56 h-56 mx-auto bg-white rounded-xl border border-dashed border-pink-300 flex flex-col items-center justify-center text-pink-400 p-4">
                                    <i class="fa-solid fa-qrcode text-5xl mb-2"></i>
                                    <span class="text-xs font-semibold">QRIS Parfum IDF</span>
                                </div>
                            @endif
                        </div>

                        <div class="text-center space-y-1">
                            <span class="text-xs text-gray-500">Total Nominal Pembayaran:</span>
                            <p class="font-serif-luxury text-3xl font-bold text-pink-950">{{ $order->formatted_grand_total }}</p>
                        </div>

                        @if($order->payment_qr_url)
                            <div>
                                <a href="{{ $order->payment_qr_url }}" download="QRIS-{{ $order->order_number }}.png" target="_blank"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-pink-100 text-pink-800 text-xs font-bold hover:bg-pink-200 transition-colors">
                                    <i class="fa-solid fa-download"></i> Unduh Kode QR
                                </a>
                            </div>
                        @endif
                    </div>

                <!-- 3. E-WALLET (GOPAY / SHOPEEPAY) -->
                @elseif(in_array($order->payment_type, ['gopay', 'shopeepay']))
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-2xl shadow-xs">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-serif-luxury text-2xl font-bold text-gray-900">Pembayaran {{ ucfirst($order->payment_type) }}</h3>
                            <p class="text-xs text-gray-500">Selesaikan pembayaran secara cepat melalui aplikasi {{ ucfirst($order->payment_type) }}.</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-2xl max-w-sm mx-auto border border-gray-200 space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Nominal Total:</span>
                                <span class="font-bold text-gray-900">{{ $order->formatted_grand_total }}</span>
                            </div>
                        </div>

                        @if($order->payment_deeplink_url)
                            <div>
                                <a href="{{ $order->payment_deeplink_url }}" target="_blank" 
                                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-emerald-600 text-white font-bold text-xs shadow-lg hover:bg-emerald-700 transition-all hover:scale-105">
                                    <i class="fa-solid fa-external-link"></i> Buka Aplikasi {{ ucfirst($order->payment_type) }}
                                </a>
                            </div>
                        @endif
                    </div>

                <!-- 4. GERAI / CSTORE (ALFAMART / INDOMARET) -->
                @elseif($order->payment_type === 'cstore' || $order->payment_code)
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 flex items-center justify-center font-bold text-lg">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">Gerai {{ strtoupper($order->payment_bank ?? 'Convenience Store') }}</h3>
                                <p class="text-xs text-gray-500">Bayar langsung di kasir Alfamart atau Indomaret terdekat</p>
                            </div>
                        </div>

                        <div class="bg-rose-50/60 rounded-2xl p-5 border border-rose-200/80 space-y-2">
                            <span class="text-xs text-gray-500 font-medium block">Kode Pembayaran Kasir:</span>
                            <div class="flex items-center justify-between gap-4">
                                <span class="font-mono text-2xl font-bold tracking-widest text-rose-950">
                                    {{ $order->payment_code }}
                                </span>
                                <button type="button" 
                                        @click="copyToClipboard('{{ $order->payment_code }}', 'code')"
                                        class="px-4 py-2 rounded-xl bg-white border border-rose-300 text-rose-800 hover:bg-rose-100 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                    <i class="fa-regular fa-copy"></i>
                                    <span x-text="copiedField === 'code' ? 'Tersalin!' : 'Salin Kode'"></span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-2xl text-xs space-y-2">
                            <p class="font-bold text-gray-800">Petunjuk Pembayaran di Kasir:</p>
                            <ol class="list-decimal list-inside space-y-1 text-gray-600 leading-relaxed">
                                <li>Kunjungi gerai {{ strtoupper($order->payment_bank ?? 'Alfamart / Indomaret') }} terdekat.</li>
                                <li>Sampaikan kepada kasir bahwa Anda ingin melakukan pembayaran merchant Midtrans / Parfum IDF.</li>
                                <li>Tunjukkan Kode Pembayaran: <strong class="font-mono text-rose-700">{{ $order->payment_code }}</strong>.</li>
                                <li>Bayar tagihan sebesar <strong class="text-rose-700">{{ $order->formatted_grand_total }}</strong> dan simpan struk pembayaran Anda.</li>
                            </ol>
                        </div>
                    </div>

                <!-- 5. MANUAL TRANSFER OPTION -->
                @elseif($order->payment_type === 'manual_transfer')
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-200 flex items-center justify-center font-bold text-lg">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">Transfer Bank Manual</h3>
                                <p class="text-xs text-gray-500">Transfer ke rekening resmi Parfum IDF dan unggah bukti transfer</p>
                            </div>
                        </div>

                        <div class="bg-purple-50/50 rounded-2xl p-5 border border-purple-200 space-y-3 text-xs">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Bank Tujuan:</span>
                                <span class="font-bold text-purple-950">Bank Central Asia (BCA)</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Nomor Rekening:</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-purple-950 text-sm">123-456-7890</span>
                                    <button type="button" @click="copyToClipboard('1234567890', 'manual_acc')"
                                            class="text-purple-700 hover:text-purple-900 font-semibold underline">
                                        <span x-text="copiedField === 'manual_acc' ? 'Tersalin!' : 'Salin'"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Atas Nama:</span>
                                <span class="font-semibold text-purple-950">PT Parfum IDF Luxury</span>
                            </div>
                        </div>

                        <!-- Form Upload Proof -->
                        <form method="POST" action="{{ route('orders.upload_proof', $order->id) }}" enctype="multipart/form-data" class="space-y-4 pt-2">
                            @csrf
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-gray-800">Unggah Bukti Transfer / Resi</label>
                                <input type="file" name="payment_proof" required accept="image/*"
                                       class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200">
                            </div>
                            <button type="submit" class="w-full py-3 rounded-full bg-purple-600 text-white font-bold text-xs hover:bg-purple-700 transition-colors shadow-md">
                                <i class="fa-solid fa-upload mr-2"></i> Unggah Bukti Pembayaran
                            </button>
                        </form>
                    </div>

                <!-- 6. KARTU KREDIT / DEBIT METHOD -->
                @elseif($order->payment_type === 'credit_card')
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg space-y-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto text-2xl shadow-xs">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-serif-luxury text-2xl font-bold text-gray-900">Pembayaran Kartu Kredit / Debit</h3>
                            <p class="text-xs text-gray-500">Pembayaran diproses secara aman melalui Midtrans 3D Secure.</p>
                        </div>

                        <div class="bg-blue-50/50 p-5 rounded-2xl max-w-sm mx-auto border border-blue-200 space-y-2 text-xs text-left">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Status Transaksi:</span>
                                <span class="font-bold text-blue-900 uppercase">Menunggu Otorisasi / Diproses</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Nominal Total:</span>
                                <span class="font-serif-luxury font-bold text-blue-950 text-base">{{ $order->formatted_grand_total }}</span>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500">
                            Silakan periksa notifikasi perbankan atau SMS OTP Anda untuk memverifikasi transaksi.
                        </p>
                    </div>

                <!-- 6. DEFAULT SNAP POPUP ACTION (WHEN NO SPECIFIC METHOD YET) -->
                @else
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-pink-100 shadow-lg text-center space-y-6">
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-pink-600">PEMBAYARAN EKSKLUSIF MIDTRANS</span>
                            <h3 class="font-serif-luxury text-2xl font-bold text-gray-900">Pilih Metode Pembayaran</h3>
                            <p class="text-xs text-gray-500 max-w-md mx-auto">
                                Tersedia pembayaran instan melalui QRIS, Virtual Account (BCA, BNI, BRI, Mandiri, Permata), GoPay, ShopeePay, Alfamart, Indomaret, & Kartu Kredit.
                            </p>
                        </div>

                        <!-- Supported Badges Icons -->
                        <div class="flex flex-wrap justify-center items-center gap-3 text-xs text-gray-600 font-semibold py-2">
                            <span class="px-3 py-1.5 rounded-full bg-pink-50 border border-pink-200 flex items-center gap-1.5"><i class="fa-solid fa-qrcode text-pink-600"></i> QRIS</span>
                            <span class="px-3 py-1.5 rounded-full bg-amber-50 border border-amber-200 flex items-center gap-1.5"><i class="fa-solid fa-building-columns text-amber-600"></i> Virtual Account</span>
                            <span class="px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 flex items-center gap-1.5"><i class="fa-solid fa-wallet text-emerald-600"></i> GoPay / ShopeePay</span>
                            <span class="px-3 py-1.5 rounded-full bg-rose-50 border border-rose-200 flex items-center gap-1.5"><i class="fa-solid fa-store text-rose-600"></i> Alfamart / Indomaret</span>
                            <span class="px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 flex items-center gap-1.5"><i class="fa-solid fa-credit-card text-blue-600"></i> Kartu Kredit</span>
                        </div>

                        <!-- Big Trigger Snap Button -->
                        <div class="pt-2">
                            <button type="button" 
                                    @click="payWithSnap()" 
                                    class="px-10 py-4 rounded-full bg-pink-gold-gradient text-white text-sm font-bold shadow-xl hover:scale-105 transition-all cursor-pointer inline-flex items-center gap-2">
                                <i class="fa-solid fa-lock text-amber-300"></i> Bayar Sekarang (Midtrans Snap)
                            </button>
                        </div>
                    </div>
                @endif

                <!-- ORDER ITEMS SUMMARY CARD -->
                <div class="bg-white rounded-3xl p-6 border border-pink-100 shadow-md space-y-4">
                    <h4 class="font-serif-luxury font-bold text-sm text-gray-900 border-b border-gray-100 pb-3 flex justify-between items-center">
                        <span>Ringkasan Rincian Pesanan</span>
                        <span class="text-xs font-normal text-gray-500">{{ $order->items->count() }} Produk</span>
                    </h4>

                    <div class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <div class="py-3 flex items-center justify-between gap-4 text-xs">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $item->product_name }}</p>
                                    <p class="text-gray-500 text-[11px]">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-3 space-y-1.5 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal Produk:</span>
                            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim ({{ $order->shipping_courier }}):</span>
                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-pink-950 pt-2 border-t border-gray-100">
                            <span>Grand Total:</span>
                            <span class="text-pink-600">{{ $order->formatted_grand_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button: Change Payment Method -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-xs font-semibold text-gray-600 hover:text-pink-600">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Rincian Pesanan
                    </a>

                    <form method="POST" action="{{ route('orders.update_payment_method', $order->id) }}">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Apakah Anda yakin ingin mengganti metode pembayaran?')"
                                class="px-5 py-2.5 rounded-full bg-white border border-pink-300 text-pink-700 hover:bg-pink-50 text-xs font-bold transition-all shadow-xs cursor-pointer">
                            <i class="fa-solid fa-rotate mr-1.5"></i> Ganti Metode Pembayaran
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Include Midtrans Snap JS Script -->
@if($snapUrl && $clientKey)
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    <script>
        function payWithSnap() {
            if (typeof window.snap === 'undefined') {
                alert('Midtrans Snap SDK sedang dimuat. Silakan coba beberapa saat lagi.');
                return;
            }
            window.snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result) {
                    window.location.reload();
                },
                onPending: function(result) {
                    window.location.reload();
                },
                onError: function(result) {
                    window.location.reload();
                },
                onClose: function() {
                    // stayed on payment page
                }
            });
        }
    </script>
@endif
@endsection
