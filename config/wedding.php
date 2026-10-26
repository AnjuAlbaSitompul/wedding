<?php

return [
    'name_order' => env('WEDDING_NAME_ORDER', 'bride_first'), // bride_first | groom_first

    'groom' => [
        'full_name' => 'Ramadani',
        'nickname' => 'Dani',
        'father' => 'Bapak Misto',
        'mother' => 'Ibu Sugini',
        'instagram' => '',
        'photo' => null,
    ],

    'bride' => [
        'full_name' => 'Dessi Putri Wulandari',
        'nickname' => 'Desi',
        'father' => 'Alm. Bapak Zulkarnain',
        'mother' => 'Ibu Amriwati',
        'instagram' => '',
        'photo' => null,
    ],

    'akad' => [
        'day' => 'Sabtu',
        'date' => '28 November 2026',
        'time' => '09.00 WIB s/d Selesai',
        'address' => 'Jl. Stasiun Lorong Sekolah No. 4, Belawan',
        'district' => 'Medan Belawan Kota',
        'subdistrict' => 'Belawan I',
        'city' => 'Medan',
        'province' => 'Sumatera Utara',
        'postal_code' => '20411',
        'maps_url' => '',
    ],

    'resepsi' => [
        'day' => 'Sabtu',
        'date' => '28 November 2026',
        'time' => '09.00 WIB s/d Selesai',
        'address' => 'Jl. Stasiun Lorong Sekolah No. 4, Belawan',
        'district' => 'Medan Belawan Kota',
        'subdistrict' => 'Belawan I',
        'city' => 'Medan',
        'province' => 'Sumatera Utara',
        'postal_code' => '20411',
        'maps_url' => '',
    ],

    'turut_mengundang' => [
        'Keluarga Bapak Misto & Ibu Sugini',
        'Keluarga Alm. Bapak Zulkarnain & Ibu Amriwati',
    ],

    'generate_password' => env('GENERATE_PASSWORD', 'ubah-password-ini'),

    'domain' => env('APP_URL', 'http://localhost:8000'),

    'og' => [
        'title' => 'The Wedding of Dani & Desi',
        'description' => "Sabtu, 28 November 2026 — You're Invited!",
        'image' => 'images/og-image.jpg',
    ],
];
