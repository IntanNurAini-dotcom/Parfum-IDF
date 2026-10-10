# Parfum IDF - Luxury Rose Gold Perfume E-Commerce Platform

Sistem E-Commerce Wewangian Mewah (**Parfum IDF**) dibangun menggunakan **Laravel 11 / 13**, **Laravel Breeze (Blade)**, **Tailwind CSS**, **Alpine.js**, dan **MySQL**. Aplikasi ini mengusung estetika **Pink Gold & Rose Luxury** yang elegan dan siap didedikasikan dari tahap pengembangan hingga siap deploy.

---

## 🌟 Fitur Utama

### Sisi Pembeli (Customer Flow)
1. **Beranda Luxury**: Banner interaktif, kategori wewangian utama, produk pilihan (featured), dan edukasi Olfaktori (Piramida Aroma: Top, Middle, Base Notes).
2. **Katalog Wewangian & Filter Dynamic**: Filter berdasarkan kata kunci/notes, kategori wewangian, rentang harga, dan pengurutan (Terbaru, Termurah, Termahal).
3. **Detail Produk**: Tampilan foto resolusi tinggi, detail piramida aroma (Top/Middle/Base Notes), ukuran botol (ML), stok real-time, dan form penambahan kuantitas ke keranjang.
4. **Keranjang Belanja Interaktif**: Live update kuantitas item, hapus item, dan perhitungan subtotal otomatis.
5. **Checkout & Pengiriman**: Form data penerima,pilihan ekspedisi kurir (JNE, J&T, SiCepat), perhitungan ongkos kirim, dan instruksi pembayaran bank transfer / QRIS.
6. **Pesanan Saya**: Riwayat transaksi, pelacakan status pesanan/pembayaran, dan form unggah bukti transfer.

### Sisi Admin (Dashboard Control Panel)
1. **Overview Dashboard**: Ringkasan total pendapatan lunas, pesanan pending, total produk parfum, total pelanggan, dan pesanan terbaru.
2. **Kelola Kategori**: CRUD kategori wewangian (Extrait de Parfum, Eau de Parfum, Body Mist, Luxury Niche) lengkap dengan upload gambar.
3. **Kelola Produk Parfum**: CRUD varian parfum lengkap dengan harga, stok, ukuran (ML), piramida aroma (Top, Middle, Base notes), foto produk, serta toggle *Featured* dan *Status Aktif*.
4. **Kelola Pesanan & Verifikasi Transfer**: 
   - Filter pesanan berdasarkan status (`pending`, `processing`, `shipped`, `completed`, `cancelled`) dan status pembayaran.
   - Modal preview bukti transfer bank dari pembeli.
   - Update status bayar, status pesanan, dan input nomor resi pengiriman (AWB).

### Struktur Midtrans (PRD Bagian 11)
- Konfigurasi variabel di `.env` (`MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, dll).
- Service Class Stub: `App\Services\MidtransService.php` (`createSnapToken(Order $order)`).
- Route & Controller Webhook Stub: `POST /api/midtrans/notification` (`MidtransWebhookController`).

---

## 🔑 Akun Demo untuk Pengujian

| Role | Email | Password |
|---|---|---|
| **Administrator** | `admin@gmail.com` | `admin12345` |
| **Pembeli Demo** | `pembeli@gmail.com` | `pembeli12345` |

---

## 🚀 Panduan Menjalankan Aplikasi Secara Lokal

### 1. Prasyarat Environment
- PHP 8.2+ (PHP 8.3 terdeteksi)
- Composer 2.x
- Node.js 20+ / npm 10+
- MySQL Server (Database: `parfum_idf`)

### 2. Langkah Setup Quick Start
```bash
# 1. Pastikan file .env sudah dikonfigurasi (DB_DATABASE=parfum_idf)
# 2. Jalankan migrasi database dan seeder data awal
php artisan migrate:fresh --seed

# 3. Buat symlink untuk storage gambar
php artisan storage:link

# 4. Build asset frontend Tailwind & JavaScript
npm run build

# 5. Jalankan server lokal Laravel
php artisan serve
```
Akses aplikasi di browser pada alamat: `http://127.0.0.1:8000`

---

## 🛡️ Pengujian Otomatis (E2E Test)
Untuk memverifikasi alur registrasi, login, tambah keranjang, checkout, unggah bukti bayar, hingga ubah status oleh admin:
```bash
php artisan test --filter ParfumIdfFlowTest
```

---

## ☁️ Panduan Deploy ke Production
1. **Database setup**: Buat database MySQL di server prod dan perbarui kredensial `.env`.
2. **Environment**: Ubah `APP_ENV=production` dan `APP_DEBUG=false`.
3. **Optimization**:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   php artisan storage:link
   ```
4. **Webserver Config**: Arahkan Document Root Nginx / Apache ke folder `/public`.
# Parfum-IDF
