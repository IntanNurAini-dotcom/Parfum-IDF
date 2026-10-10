<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Parfum IDF') }} - Luxury Rose Gold Fragrances</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDF8F5;
            color: #2D1527;
        }
        .font-serif-luxury {
            font-family: 'Playfair Display', serif;
        }
        .bg-pink-gold-gradient {
            background: linear-gradient(135deg, #7A1C4E 0%, #B8477D 45%, #D96E9F 75%, #8B2057 100%);
        }
        .bg-rose-gold {
            background: linear-gradient(135deg, #E8A5C8 0%, #D484B7 50%, #C25993 100%);
        }
        .text-gold {
            color: #D4AF37;
        }
        .border-gold {
            border-color: #E8A5C8;
        }
        .bg-gold-light {
            background-color: #FFF9F2;
        }
        .btn-pink-gold {
            background: linear-gradient(135deg, #D484B7 0%, #C25993 100%);
            color: #ffffff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 132, 183, 0.3);
        }
        .btn-pink-gold:hover {
            background: linear-gradient(135deg, #C25993 0%, #A33A76 100%);
            box-shadow: 0 6px 20px rgba(212, 132, 183, 0.5);
            transform: translateY(-2px);
        }
        .card-luxury {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(232, 165, 200, 0.3);
            box-shadow: 0 10px 30px rgba(74, 30, 60, 0.05);
            border-radius: 1.25rem;
            transition: all 0.3s ease;
        }
        .card-luxury:hover {
            box-shadow: 0 15px 35px rgba(212, 132, 183, 0.2);
            border-color: rgba(212, 132, 183, 0.6);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-between">
    <!-- Top Bar Notice -->
    <div class="bg-pink-gold-gradient text-amber-100 text-xs py-2 px-4 text-center tracking-widest font-medium border-b border-white/20">
        {{ config('store.top_bar_notice') }}
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-full bg-rose-gold flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                        <i class="fa-solid fa-spray-can text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="font-serif-luxury font-bold text-2xl tracking-wider text-pink-950 block leading-none">PARFUM <span class="text-pink-600">IDF</span></span>
                        <span class="text-[10px] tracking-[0.25em] text-pink-500 font-semibold uppercase block mt-1">Haute Parfumerie</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 font-medium text-sm text-gray-700">
                    <a href="{{ route('home') }}" class="hover:text-pink-600 transition-colors {{ request()->routeIs('home') ? 'text-pink-600 font-semibold border-b-2 border-pink-500 pb-1' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('catalog.index') }}" class="hover:text-pink-600 transition-colors {{ request()->routeIs('catalog.*') ? 'text-pink-600 font-semibold border-b-2 border-pink-500 pb-1' : '' }}">
                        Katalog Wewangian
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" class="hover:text-pink-600 transition-colors {{ request()->routeIs('orders.*') ? 'text-pink-600 font-semibold border-b-2 border-pink-500 pb-1' : '' }}">
                            Pesanan Saya
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-bold hover:bg-amber-200 transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-crown text-amber-600"></i> Admin Panel
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Action Icons & Account -->
                <div class="flex items-center space-x-5">
                    <!-- Search Bar Shortcut -->
                    <form action="{{ route('catalog.index') }}" method="GET" class="hidden sm:flex items-center relative">
                        <input type="text" name="q" placeholder="Cari parfum, notes..." value="{{ request('q') }}"
                            class="w-44 focus:w-60 transition-all duration-300 pl-9 pr-4 py-1.5 text-xs rounded-full border border-pink-200 bg-pink-50/50 focus:bg-white focus:border-pink-500 focus:ring-0">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 text-pink-400 text-xs"></i>
                    </form>

                    <!-- Cart Icon -->
                    @auth
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                        @endphp
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-pink-600 transition-colors">
                            <i class="fa-solid fa-bag-shopping text-xl"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-pink-600 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="relative p-2 text-gray-700 hover:text-pink-600 transition-colors">
                            <i class="fa-solid fa-bag-shopping text-xl"></i>
                        </a>
                    @endauth

                    <!-- User Profile / Auth Dropdown -->
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-semibold text-gray-800 hover:text-pink-600 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-pink-100 border border-pink-300 text-pink-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                <span class="hidden lg:inline text-xs">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-pink-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Login sebagai:</p>
                                    <p class="text-xs font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-xs text-gray-700 hover:bg-pink-50 hover:text-pink-600">
                                    <i class="fa-solid fa-box mr-2 text-pink-400"></i> Pesanan Saya
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-amber-700 font-semibold hover:bg-amber-50">
                                        <i class="fa-solid fa-gauge mr-2 text-amber-500"></i> Dashboard Admin
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-pink-700 hover:text-pink-900 px-3 py-2">Masuk</a>
                            <a href="{{ route('register') }}" class="text-xs font-semibold btn-pink-gold px-4 py-2 rounded-full">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer Pink Gold Luxury -->
    <footer class="bg-pink-gold-gradient text-white pt-16 pb-8 border-t border-white/20 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/20">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-rose-gold flex items-center justify-center">
                            <i class="fa-solid fa-spray-can text-white text-base"></i>
                        </div>
                        <span class="font-serif-luxury font-bold text-xl text-white tracking-wider">PARFUM IDF</span>
                    </div>
                    <p class="text-xs text-pink-200/80 leading-relaxed">
                        Rumah wewangian mewah dengan kombinasi ekstrak bunga pilihan, kayu berharga, dan piramida aroma bertaraf internasional.
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="#" class="w-8 h-8 rounded-full bg-pink-900/60 hover:bg-pink-600 flex items-center justify-center text-pink-200 text-xs transition-colors"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-pink-900/60 hover:bg-pink-600 flex items-center justify-center text-pink-200 text-xs transition-colors"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-pink-900/60 hover:bg-pink-600 flex items-center justify-center text-pink-200 text-xs transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Col 2: Navigation -->
                <div>
                    <h4 class="font-serif-luxury text-amber-300 font-semibold text-sm mb-4 tracking-wider">Koleksi Wewangian</h4>
                    <ul class="space-y-2 text-xs text-pink-100/70">
                        <li><a href="{{ route('catalog.index', ['category' => 'parfum-idf']) }}" class="hover:text-pink-300 transition-colors">Parfum IDF</a></li>
                        <li><a href="{{ route('catalog.index', ['category' => 'body-mist']) }}" class="hover:text-pink-300 transition-colors">Body Mist</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Care -->
                <div>
                    <h4 class="font-serif-luxury text-amber-300 font-semibold text-sm mb-4 tracking-wider">Bantuan & Layanan</h4>
                    <ul class="space-y-2 text-xs text-pink-100/70">
                        <li><a href="{{ route('orders.index') }}" class="hover:text-pink-300 transition-colors">Lacak Pesanan Saya</a></li>
                        <li><a href="{{ route('home') }}#scent-pyramid" class="hover:text-pink-300 transition-colors">Panduan Piramida Aroma</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-pink-300 transition-colors">Katalog Lengkap</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div class="space-y-3">
                    <h4 class="font-serif-luxury text-amber-300 font-semibold text-sm mb-4 tracking-wider">Boutique IDF</h4>
                    <p class="text-xs text-pink-100/70 flex items-start gap-2">
                        <i class="fa-solid fa-location-dot text-amber-400 mt-1"></i>
                        {{ config('store.address') }}
                    </p>
                    <p class="text-xs text-pink-100/70 flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-amber-400"></i>
                        {{ config('store.email') }}
                    </p>
                    <p class="text-xs text-pink-100/70 flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-amber-400"></i>
                        <a href="https://wa.me/{{ config('store.whatsapp') }}" target="_blank" class="hover:text-amber-300 transition-colors">
                            +{{ config('store.whatsapp') }} (WhatsApp)
                        </a>
                    </p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 text-center text-xs text-pink-300/60 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Parfum IDF. All rights reserved. Pink Gold Edition.</p>
                <div class="flex items-center space-x-4 text-sm text-pink-300/40">
                    <i class="fa-brands fa-cc-visa"></i>
                    <i class="fa-brands fa-cc-mastercard"></i>
                    <i class="fa-solid fa-building-columns"></i>
                    <i class="fa-solid fa-qrcode"></i>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
