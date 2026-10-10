<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'Parfum IDF') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F5F8;
            color: #2D1527;
        }
        .font-serif-luxury {
            font-family: 'Playfair Display', serif;
        }
        .sidebar-admin {
            background: linear-gradient(180deg, #1F0D1B 0%, #30142B 100%);
        }
        .btn-pink-gold {
            background: linear-gradient(135deg, #D484B7 0%, #C25993 100%);
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn-pink-gold:hover {
            background: linear-gradient(135deg, #C25993 0%, #A33A76 100%);
        }
    </style>
</head>
<body class="antialiased flex min-h-screen">
    <!-- Sidebar Admin -->
    <aside class="w-64 sidebar-admin text-white flex-shrink-0 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Header Logo -->
            <div class="p-6 border-b border-pink-900/50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-pink-500/20 border border-pink-400 flex items-center justify-center text-amber-300">
                    <i class="fa-solid fa-crown text-base"></i>
                </div>
                <div>
                    <h1 class="font-serif-luxury font-bold text-lg tracking-wider text-pink-100">PARFUM IDF</h1>
                    <p class="text-[10px] text-pink-300/60 uppercase tracking-widest">Admin Control Panel</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6 px-4 space-y-1.5 text-xs font-medium">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-pink-600/30 text-pink-200 border-l-4 border-pink-400 font-bold' : 'text-pink-100/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line text-sm w-5 text-pink-400"></i>
                    Dashboard Overview
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-pink-600/30 text-pink-200 border-l-4 border-pink-400 font-bold' : 'text-pink-100/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-receipt text-sm w-5 text-amber-400"></i>
                    Kelola Pesanan
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'bg-pink-600/30 text-pink-200 border-l-4 border-pink-400 font-bold' : 'text-pink-100/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-spray-can text-sm w-5 text-pink-300"></i>
                    Produk Parfum
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-pink-600/30 text-pink-200 border-l-4 border-pink-400 font-bold' : 'text-pink-100/70 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-tags text-sm w-5 text-purple-400"></i>
                    Kategori Fragrance
                </a>

                <div class="pt-6 pb-2 px-4 text-[10px] uppercase font-bold tracking-wider text-pink-400/50">
                    Situs Utama
                </div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-pink-200/70 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-globe text-sm w-5 text-teal-400"></i>
                    Lihat Toko (Buyer View)
                </a>
            </nav>
        </div>

        <!-- Footer User info -->
        <div class="p-4 border-t border-pink-900/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-amber-400/20 text-amber-300 font-bold text-xs flex items-center justify-center border border-amber-400/40">
                    AD
                </div>
                <div class="text-xs truncate">
                    <p class="font-bold text-white leading-tight truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-pink-300/60">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar" class="text-pink-300 hover:text-red-400 text-sm p-1.5">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="bg-white border-b border-pink-100 h-16 px-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}" class="md:hidden font-serif-luxury font-bold text-lg text-pink-950">PARFUM IDF ADMIN</a>
                <h2 class="text-sm font-semibold text-gray-700 hidden md:block">
                    @yield('title', 'Admin Dashboard')
                </h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-xs text-gray-500 hidden sm:block">
                    <i class="fa-regular fa-clock mr-1 text-pink-500"></i> {{ date('l, d F Y') }}
                </div>
                <div class="h-4 w-px bg-gray-200 hidden sm:block"></div>
                <a href="{{ route('home') }}" class="text-xs text-pink-600 font-semibold hover:underline">
                    Ke Beranda Pembeli &rarr;
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl p-4 flex items-center gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl p-4 flex items-center gap-3 shadow-sm mb-4">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <main class="p-6 flex-grow">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
