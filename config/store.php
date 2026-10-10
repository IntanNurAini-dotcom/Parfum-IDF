<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Parfum IDF Store Configuration
    |--------------------------------------------------------------------------
    */
    'name' => 'Parfum IDF',
    'tagline' => 'Haute Parfumerie & Luxury Fragrances',
    'phone' => env('STORE_PHONE', '0895-0201-6857'),
    'whatsapp' => env('STORE_WHATSAPP', '6289502016857'),
    'email' => env('STORE_EMAIL', 'contact@parfumidf.com'),
    'address' => env('STORE_ADDRESS', 'Jakarta, Indonesia'),
    
    // Marketing Claim Badges for Hero Section (Neutral Defaults)
    'claims' => [
        'longevity' => [
            'value' => 'Tahan Lama',
            'label' => 'Formulasi Teruji',
        ],
        'purity' => [
            'value' => 'Konsentrat Pilihan',
            'label' => 'Bahan Berkualitas',
        ],
        'ethical' => [
            'value' => 'Standar Mutu',
            'label' => 'Aman & Nyaman',
        ],
    ],

    // Top Header Banner Announcement
    'top_bar_notice' => '✦ PARFUM IDF LUXURY COLLECTION - KOLEKSI WEWANGIAN EKSKLUSIF TERBAIK ✦',
];
