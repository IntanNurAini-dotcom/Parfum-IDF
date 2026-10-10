# Product Requirement Document (PRD) - Parfum IDF
**Luxury Perfume E-Commerce Platform**
*Versi: 1.1 | Status: Dalam Pengembangan (Capstone)*

---

## 1. Latar Belakang & Visi Produk
**Parfum IDF** adalah platform e-commerce eksklusif yang menyajikan koleksi wewangian mewah dengan estetika **Pink Gold & Rose Luxury**. Aplikasi dirancang untuk pengalaman berbelanja parfum yang elegan, cepat, aman, dan intuitif. Proyek ini adalah capstone dengan syarat wajib: **fullstack dan siap di-deploy**.

---

## 2. Arsitektur & Teknologi Stack
- **Framework**: Laravel 13.x (PHP 8.3)
- **Auth**: Laravel Breeze (Blade)
- **Frontend**: Tailwind CSS + Alpine.js
- **Database**: MySQL 8.x (`parfum_idf`)
- **Asset bundling**: Vite
- **Storage**: Local disk (`storage/app/public`, symlink ke `public/storage`)

---

## 3. Tema Visual (Pink Gold Luxury)
- **Warna utama (Rose Gold)**: `#E8A5C8` / `#D484B7`, gradasi `from-pink-500 to-amber-400`
- **Aksen (Champagne Gold)**: `#D4AF37` / `#F3E5AB`
- **Latar**: Soft Cream `#FDF8F5`, Deep Plum `#1A0F1A`
- **Tipografi**: Playfair Display untuk judul, Inter/sans-serif untuk teks
- **UI**: bayangan lembut, border emas tipis, kartu `rounded-2xl`, animasi halus, responsif penuh (mobile first)

---

## 4. Skema Database (sesuai tabel yang sudah ada)

### users
`id`, `name`, `email` (unique), `password`, `role` (admin/customer, default customer), `phone`, `address`, `remember_token`, timestamps

### categories
`id`, `name`, `slug` (unique), `description`, `image`, timestamps

### products
`id`, `category_id` (FK), `name`, `slug` (unique), `description`, `price` (decimal 12,2), `stock`, `size` (string, mis. "50 ml"), `top_notes`, `middle_notes`, `base_notes`, `image`, `is_featured`, `is_active`, timestamps

### carts
`id`, `user_id` (FK), `product_id` (FK), `quantity`, timestamps

### orders
`id`, `user_id` (FK), `order_number` (unique, mis. IDF-20261007-XXXX), `total_amount`, `shipping_name`, `shipping_phone`, `shipping_address`, `shipping_city`, `shipping_courier`, `shipping_cost`, `grand_total`, `payment_status` (unpaid/paid/refunded), `payment_proof`, `order_status` (pending/processing/shipped/completed/cancelled), `tracking_number`, `notes`, timestamps

### order_items
`id`, `order_id` (FK), `product_id` (FK), `quantity`, `price`, `subtotal`, timestamps

> Perubahan skema hanya boleh lewat **migration baru** (`php artisan migrate`), tidak boleh mengosongkan database.

---

## 5. Fitur Sisi Pembeli
1. **Beranda**: hero bertema pink gold dengan produk unggulan asli, kategori utama (Parfum IDF dan Body Mist), produk unggulan, piramida aroma, dan footer dengan kontak WhatsApp toko.
2. **Katalog & Filter**: pencarian nama/aroma, filter kategori dan rentang harga, urutkan (terbaru, termurah, termahal), pagination.
3. **Detail Produk**: foto, ukuran, harga, stok, piramida aroma (top/middle/base), tombol tambah keranjang, tombol tanya via WhatsApp.
4. **Keranjang**: ubah jumlah, hapus item, ringkasan subtotal.
5. **Checkout & Pembayaran**: alamat pengiriman, pilihan kurir dan ongkir, pilihan metode bayar (Midtrans atau transfer manual).
6. **Pesanan Saya**: riwayat dan status pesanan, upload bukti pembayaran, tombol bayar untuk pesanan yang belum dibayar.

---

## 6. Fitur Sisi Admin
1. **Dashboard**: total pendapatan, pesanan pending, total produk, total pelanggan, stok menipis.
2. **Kategori**: CRUD beserta gambar.
3. **Produk**: CRUD lengkap (harga, stok, notes aroma, upload foto, status aktif/unggulan).
4. **Pesanan**: filter status, verifikasi bukti transfer, ubah status, input nomor resi, tampilkan metode dan status pembayaran.

---

## 7. Data Awal (REVISI, produk asli)
- **Akun TIDAK dibuat oleh DatabaseSeeder.** Akun dibuat manual lewat tinker:
  - Admin: `admin@gmail.com` / `admin12345` (role admin)
  - Pembeli: `pembeli@gmail.com` / `pembeli12345` (role customer)
- **Katalog diisi oleh `database/seeders/CatalogSeeder.php`** (updateOrInsert, aman dijalankan berulang). Ini satu-satunya sumber data katalog. Dilarang membuat produk contoh lain.
- **Kategori (2)**: Parfum IDF, Body Mist
- **Produk (10)**:
  - Parfum IDF: Aura Marle, Rose Haze, Golden One, Eterna Black, Botanica Rosea
  - Body Mist: Luxcury Out, Night Eclipse, Vleured'or, Royale Deluxe, Baby Soie
- Harga sementara: Parfum IDF Rp 249.000 (50 ml), Body Mist Rp 99.000 (100 ml). Diubah lewat admin.
- **Foto**: `storage/app/public/products/{slug}.jpg` (contoh `aura-marle.jpg`), foto kategori `categories/{slug}.jpg`. Jika file belum ada, tampilkan placeholder SVG bertema pink gold.
- **Kontak toko**: WhatsApp +62 895-0201-6857 (tautan `6289502016857`), disimpan di `config/store.php`/`.env`, bukan hardcode.

---

## 8. Keamanan & Validasi
- Middleware `auth` dan pengecekan role admin; pembeli yang membuka `/admin` mendapat 403.
- Upload gambar/bukti bayar: jpg, jpeg, png, webp, maksimal 2 MB.
- Perlindungan XSS, CSRF, SQL injection (Eloquent), password di-hash, rate limiting login.
- Total harga selalu dihitung di server, bukan dari browser.

---

## 9. Halaman Error Kustom
`404`, `403`, `500` bertema pink gold.

---

## 10. Panduan Deployment (REVISI)
1. Siapkan `.env` (database, APP_KEY, kunci Midtrans, `APP_ENV=production`, `APP_DEBUG=false`).
2. `composer install --no-dev --optimize-autoloader`
3. `npm ci && npm run build`
4. `php artisan key:generate` (hanya jika APP_KEY kosong)
5. `php artisan migrate --force` (**bukan** `migrate:fresh`)
6. `php artisan db:seed --class=CatalogSeeder`
7. Buat akun admin lewat tinker.
8. `php artisan storage:link`
9. `php artisan config:cache && php artisan route:cache && php artisan view:cache`

---

## 11. Pembayaran (Midtrans Snap, sandbox)
- `.env`: `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION=false`
- `App\Services\MidtransService` membuat Snap token dari order (`order_number` sebagai order_id, `grand_total` sebagai gross_amount, ongkir sebagai item tersendiri).
- Metode: QRIS, Virtual Account (BCA, BNI, BRI, Mandiri, Permata), e-wallet, kartu, gerai. Transfer manual tetap tersedia.
- Webhook: `POST /api/midtrans/notification` dengan verifikasi `signature_key`, idempotent. settlement/capture menjadi paid, expire/cancel/deny menjadi cancelled dan stok dikembalikan.
- Halaman detail pembayaran: nomor VA, QR, hitung mundur, status otomatis.
- Gunakan nama kolom sesuai skema di bagian 4 (`order_number`, `grand_total`, `payment_status`, `order_status`).

---

## 12. Aturan Wajib untuk Agent (JANGAN DILANGGAR)
1. **Dilarang** menjalankan `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `db:wipe`, atau perintah apa pun yang menghapus tabel/data.
2. **Dilarang** menyentuh tabel `users`, `sessions`, fitur login/autentikasi, dan akun pengguna, kecuali diminta secara eksplisit.
3. Perubahan struktur database hanya lewat **migration baru**, dijalankan dengan `php artisan migrate`.
4. `DatabaseSeeder` tidak boleh membuat atau mengubah user. Data katalog hanya lewat `CatalogSeeder`.
5. Jangan menjalankan perintah terminal tanpa persetujuan pengguna. Jika perlu perintah, tuliskan dan biarkan pengguna yang menjalankannya.
6. Jangan menulis kredensial atau data palsu di kode. Ambil dari config/.env/database.