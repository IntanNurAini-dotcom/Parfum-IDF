<?php

return [
    'required' => 'Kolom :attribute wajib diisi.',
    'email' => 'Format :attribute tidak valid.',
    'min' => [
        'numeric' => 'Kolom :attribute minimal bernilai :min.',
        'file' => 'Ukuran :attribute minimal :min kilobyte.',
        'string' => 'Kolom :attribute minimal berisi :min karakter.',
        'array' => 'Kolom :attribute minimal memiliki :min anggota.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute maksimal bernilai :max.',
        'file' => 'Ukuran :attribute maksimal :max kilobyte.',
        'string' => 'Kolom :attribute maksimal berisi :max karakter.',
        'array' => 'Kolom :attribute maksimal memiliki :max anggota.',
    ],
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':Attribute sudah terdaftar.',
    'string' => 'Kolom :attribute harus berupa teks.',
    'attributes' => [
        'email' => 'alamat email',
        'password' => 'kata sandi',
        'name' => 'nama lengkap',
        'phone' => 'nomor telepon',
        'password_confirmation' => 'konfirmasi kata sandi',
    ],
];
