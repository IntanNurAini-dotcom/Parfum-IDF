<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Parfum IDF') }} - Haute Parfumerie</title>

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDF2F4;
            color: #3B2A2E;
        }
        .font-serif-luxury {
            font-family: 'Playfair Display', serif;
        }

        /* Webkit Autofill Override Fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #FFFFFF inset !important;
            -webkit-text-fill-color: #3B2A2E !important;
            border-radius: 1rem !important;
        }

        /* Floating perfume bottle animation */
        @keyframes floatPerfume {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-12px) rotate(1.5deg);
            }
        }

        /* Floating sparkle particles animation */
        @keyframes floatSparkle {
            0% {
                transform: translateY(0px) scale(0.9);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-20px) scale(1.15);
                opacity: 0.85;
            }
            100% {
                transform: translateY(-40px) scale(0.9);
                opacity: 0.2;
            }
        }

        /* Fade-up entrance animation */
        @keyframes fadeUpEntrance {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            .animate-float-bottle {
                animation: floatPerfume 6s ease-in-out infinite;
            }
            .animate-sparkle-slow {
                animation: floatSparkle 5s ease-in-out infinite;
            }
            .animate-sparkle-fast {
                animation: floatSparkle 3.5s ease-in-out infinite 1s;
            }
            .animate-sparkle-delay {
                animation: floatSparkle 6s ease-in-out infinite 2s;
            }
            .animate-fade-up {
                animation: fadeUpEntrance 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
        }

        /* Rose Gold to Gold Shimmer Button */
        .btn-rose-gold-shimmer {
            background: linear-gradient(135deg, #B76E79 0%, #C9A24D 50%, #B76E79 100%);
            background-size: 200% auto;
            transition: all 0.4s ease;
            box-shadow: 0 4px 20px rgba(183, 110, 121, 0.35);
        }
        .btn-rose-gold-shimmer:hover {
            background-position: right center;
            box-shadow: 0 8px 25px rgba(201, 162, 77, 0.45);
            transform: translateY(-2px);
        }
        .btn-rose-gold-shimmer:active {
            transform: translateY(0);
        }

        /* Custom Glass Card Cream */
        .glass-card-cream {
            background: rgba(255, 250, 245, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(201, 162, 77, 0.35);
            box-shadow: 0 20px 50px rgba(59, 42, 46, 0.08);
        }

        /* Input Focus Glow */
        .input-luxury {
            background-color: #FFFFFF;
            border: 1.5px solid rgba(183, 110, 121, 0.3);
            transition: all 0.3s ease;
        }
        .input-luxury:focus {
            border-color: #B76E79;
            box-shadow: 0 0 16px rgba(183, 110, 121, 0.25);
            outline: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen text-[#3B2A2E] bg-[#FDF2F4] flex flex-col justify-between">

    <div class="min-h-screen flex flex-col md:flex-row w-full overflow-x-hidden">
        
        <!-- LEFT PANEL: BRAND BOUTIQUE (55% on desktop, top banner on mobile) -->
        <div class="w-full md:w-[55%] bg-gradient-to-br from-[#FDF2F4] via-[#F8D7DA] to-[#F4C2CC] relative flex flex-col justify-between p-6 sm:p-10 lg:p-14 overflow-hidden border-b md:border-b-0 md:border-r border-[#F4C2CC]">
            
            <!-- Subtle Pattern Overlay -->
            <div class="absolute inset-0 pointer-events-none opacity-25 bg-[radial-gradient(#C9A24D_0.75px,transparent_0.75px)] [background-size:24px_24px]"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#F4C2CC]/50 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#C9A24D]/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Floating Sparkle Particles -->
            <div class="absolute top-1/4 left-1/5 text-[#C9A24D] animate-sparkle-slow pointer-events-none text-xl select-none">✦</div>
            <div class="absolute top-1/2 right-1/4 text-[#B76E79] animate-sparkle-fast pointer-events-none text-lg select-none">✧</div>
            <div class="absolute bottom-1/3 left-1/3 text-[#C9A24D] animate-sparkle-delay pointer-events-none text-sm select-none">✦</div>
            <div class="absolute top-1/3 right-1/6 text-[#F4C2CC] animate-sparkle-slow pointer-events-none text-xs select-none">✦</div>

            <!-- Top Header Navigation / Brand Badge -->
            <div class="relative z-10 flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-[#3B2A2E]/80 hover:text-[#B76E79] transition-colors bg-white/70 backdrop-blur-md px-4 py-2 rounded-full border border-rose-200/60 shadow-xs group">
                    <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    <span>Beranda</span>
                </a>
                <div class="flex items-center gap-1.5 text-[10px] font-bold tracking-widest text-[#B76E79] uppercase bg-[#FFFAF5]/90 px-3.5 py-1.5 rounded-full border border-[#C9A24D]/35 shadow-xs">
                    <i class="fa-solid fa-gem text-[#C9A24D]"></i> HAUTE PARFUMERIE
                </div>
            </div>

            <!-- Center Content: Brand Illustration & Typography -->
            <div class="relative z-10 my-8 md:my-auto flex flex-col items-center text-center">
                
                <!-- SVG Luxury Perfume Bottle Illustration -->
                <div class="relative w-40 h-48 sm:w-48 sm:h-56 lg:w-56 lg:h-64 my-2 sm:my-4 animate-float-bottle flex items-center justify-center">
                    <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full filter drop-shadow-[0_15px_25px_rgba(183,110,121,0.25)]">
                        <defs>
                            <linearGradient id="goldCapGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F3E5AB" />
                                <stop offset="50%" stop-color="#C9A24D" />
                                <stop offset="100%" stop-color="#997529" />
                            </linearGradient>
                            <linearGradient id="roseGoldBody" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#FFFAF5" stop-opacity="0.95" />
                                <stop offset="40%" stop-color="#F4C2CC" stop-opacity="0.65" />
                                <stop offset="100%" stop-color="#B76E79" stop-opacity="0.85" />
                            </linearGradient>
                            <linearGradient id="perfumeLiquid" x1="0%" y1="100%" x2="0%" y2="0%">
                                <stop offset="0%" stop-color="#B76E79" stop-opacity="0.8" />
                                <stop offset="70%" stop-color="#F4C2CC" stop-opacity="0.55" />
                                <stop offset="100%" stop-color="#FFFAF5" stop-opacity="0.15" />
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="2.5" result="coloredBlur"/>
                                <feMerge>
                                    <feMergeNode in="coloredBlur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>

                        <!-- Bottle Cap (Gold Crown) -->
                        <rect x="82" y="10" width="36" height="28" rx="6" fill="url(#goldCapGrad)" stroke="#997529" stroke-width="1.5" />
                        <rect x="76" y="38" width="48" height="12" rx="3" fill="url(#goldCapGrad)" stroke="#997529" stroke-width="1.5" />

                        <!-- Bottle Neck -->
                        <rect x="88" y="50" width="24" height="16" fill="#F4C2CC" stroke="#C9A24D" stroke-width="1.5" />

                        <!-- Bottle Main Glass Body -->
                        <path d="M50 72 C50 66, 150 66, 150 72 L162 205 C162 215, 150 225, 100 225 C50 225, 38 215, 38 205 Z" fill="url(#roseGoldBody)" stroke="url(#goldCapGrad)" stroke-width="2.5" />
                        
                        <!-- Liquid Level -->
                        <path d="M44 110 C70 105, 130 115, 156 110 L160 202 C160 212, 148 220, 100 220 C52 220, 40 212, 40 202 Z" fill="url(#perfumeLiquid)" />

                        <!-- Glass Reflections -->
                        <path d="M48 80 L44 195" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" opacity="0.65" />
                        <path d="M56 82 L53 190" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" opacity="0.45" />
                        <path d="M152 80 L156 195" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" opacity="0.35" />

                        <!-- Label Frame -->
                        <rect x="62" y="115" width="76" height="65" rx="8" fill="#FFFAF5" stroke="#C9A24D" stroke-width="1.5" filter="url(#glow)" />
                        <rect x="66" y="119" width="68" height="57" rx="6" fill="none" stroke="#B76E79" stroke-width="0.75" stroke-dasharray="2 2" />
                        <text x="100" y="142" font-family="'Playfair Display', serif" font-size="11" font-weight="bold" fill="#3B2A2E" text-anchor="middle" letter-spacing="1">PARFUM</text>
                        <text x="100" y="156" font-family="'Playfair Display', serif" font-size="13" font-weight="900" fill="#B76E79" text-anchor="middle" letter-spacing="2">IDF</text>
                        <text x="100" y="168" font-family="'Plus Jakarta Sans', sans-serif" font-size="6" font-weight="600" fill="#C9A24D" text-anchor="middle" letter-spacing="1">EXTRAIT DE PARFUM</text>
                    </svg>
                </div>

                <!-- Brand Title & Tagline -->
                <h1 class="font-serif-luxury text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-[#3B2A2E] leading-tight">
                    PARFUM <span class="text-[#B76E79]">IDF</span>
                </h1>
                <p class="font-serif-luxury italic text-base sm:text-lg lg:text-xl text-[#3B2A2E]/85 mt-2 max-w-sm">
                    "Temukan aroma yang bercerita tentangmu"
                </p>

                <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-[#C9A24D] to-transparent my-4"></div>
            </div>

            <!-- Bottom 3 Feature Badges -->
            <div class="relative z-10 grid grid-cols-3 gap-2 sm:gap-4 pt-4 border-t border-[#B76E79]/20">
                <div class="flex flex-col items-center text-center p-2.5 rounded-2xl bg-white/50 backdrop-blur-xs border border-white/70 shadow-xs">
                    <div class="w-8 h-8 rounded-full bg-[#FFFAF5] text-[#C9A24D] flex items-center justify-center shadow-xs text-xs mb-1">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <span class="text-[11px] font-bold text-[#3B2A2E]">100% Original</span>
                    <span class="text-[9px] text-[#3B2A2E]/60 hidden sm:inline">Garansi Keaslian</span>
                </div>
                <div class="flex flex-col items-center text-center p-2.5 rounded-2xl bg-white/50 backdrop-blur-xs border border-white/70 shadow-xs">
                    <div class="w-8 h-8 rounded-full bg-[#FFFAF5] text-[#C9A24D] flex items-center justify-center shadow-xs text-xs mb-1">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <span class="text-[11px] font-bold text-[#3B2A2E]">Pengiriman Aman</span>
                    <span class="text-[9px] text-[#3B2A2E]/60 hidden sm:inline">Kemasan Premium</span>
                </div>
                <div class="flex flex-col items-center text-center p-2.5 rounded-2xl bg-white/50 backdrop-blur-xs border border-white/70 shadow-xs">
                    <div class="w-8 h-8 rounded-full bg-[#FFFAF5] text-[#C9A24D] flex items-center justify-center shadow-xs text-xs mb-1">
                        <i class="fa-solid fa-spray-can text-[#B76E79]"></i>
                    </div>
                    <span class="text-[11px] font-bold text-[#3B2A2E]">Aroma Pilihan</span>
                    <span class="text-[9px] text-[#3B2A2E]/60 hidden sm:inline">Standar Internasional</span>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: FORM CONTAINER (45% on desktop, main container on mobile) -->
        <div class="w-full md:w-[45%] flex items-center justify-center p-4 sm:p-8 lg:p-12 relative bg-[#FDF2F4]">
            <div class="w-full max-w-md animate-fade-up my-auto">
                <div class="glass-card-cream rounded-3xl p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#B76E79] via-[#C9A24D] to-[#B76E79]"></div>
                    {{ $slot }}
                </div>
                
                <p class="text-center text-xs text-[#3B2A2E]/60 mt-6 font-medium">
                    &copy; {{ date('Y') }} Parfum IDF. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
