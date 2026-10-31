<p align="center">
    <span style="font-size: 28px;"><strong>Undangan Pernikahan Digital — Dani &amp; Desi</strong></span>
</p>

<p align="center">
    Sabtu, 28 November 2026 · Belawan, Medan
</p>

Aplikasi undangan pernikahan digital berbasis **Laravel 13** (PHP 8.3). Tamu membuka undangan lewat link yang dipersonalisasi, dan pemilik acara dapat membuat link personal untuk setiap tamu melalui halaman generator.

---

## Fitur

### Halaman Undangan (`/`)
- **Amplop pembuka interaktif** — tamu mengetuk amplop untuk masuk (animasi GSAP).
- **Nama tamu personal** — nama tamu tampil otomatis dari parameter link (`?g=...`), default "Bapak/Ibu/Saudara/i".
- **Scroll narrative** — perjalanan hutan menuju gerbang bunga, lalu bertemu mempelai (GSAP ScrollTrigger + Lenis smooth scroll).
- **Musik latar** — tombol putar/jeda musik (`audio/background.mp3`).
- **Efek dekorasi** — daun jatuh dan partikel melayang (canvas), animasi burung.
- **Countdown** — hitung mundur ke hari acara (hari/jam/menit/detik).
- **Detail acara** — Akad Nikah dan Resepsi lengkap dengan hari, tanggal, jam, dan alamat.
- **Profil mempelai** — data calon pengantin pria & wanita beserta orang tua.
- **Turut mengundang** — daftar keluarga yang mengundang.
- **Lokasi** — peta Google Maps (koordinat di `config/wedding.php` → `location`), ketuk untuk membuka Google Maps / petunjuk arah.
- **RSVP & Ucapan** — form konfirmasi kehadiran (hadir/berhalangan, jumlah orang) + pesan, ditampilkan real-time di *Wall of Wishes* (maksimal 50 ucapan terbaru).
- **Amplop digital** — informasi rekening (placeholder).
- **Tombol bagikan** — Share via WhatsApp & Copy Link.
- **Navigasi section** — menu navigasi antar bagian undangan.
- **SEO / Open Graph** — meta OG & Twitter Card untuk preview saat link dibagikan.

### Halaman Generator (`/generate`)
- **Login dengan password** untuk melindungi halaman generator.
- **Buat link personal** — masukkan nama tamu & nomor WhatsApp, sistem membuat link undangan terenkripsi khusus untuk tamu tersebut.
- **Preview greeting** — menampilkan "Kepada Yth. {nama}".
- **Copy link** & **Kirim via WhatsApp** — kirim undangan langsung ke tamu dengan pesan otomatis.
- **Logout** dari sesi generator.

---

## Kebutuhan

- PHP 8.3+
- Composer
- Node.js & npm
- Database (default: SQLite)

---

## Instalasi

Cara tercepat menggunakan script `setup` bawaan:

```bash
composer setup
```

Script tersebut akan menjalankan `composer install`, menyalin `.env`, generate app key, migrasi database, `npm install`, dan `npm run build`.

### Manual

```bash
composer install
copy .env.example .env      # Windows
php artisan key:generate
php artisan migrate
npm install
npm run build
```

---

## Menjalankan Aplikasi

```bash
composer dev
```

Atau jalankan langsung:

```bash
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`.

---

## Cara Menggunakan

### 1. Membuka Undangan
Buka `http://localhost:8000/` di browser. Tamu akan melihat amplop pembuka; ketuk amplop untuk masuk ke undangan.

### 2. Membuat Link Personal Tamu (`/generate`)
1. Buka `http://localhost:8000/generate`.
2. Masukkan **password generator** (lihat di bawah).
3. Isi **Nama Tamu** dan **Nomor WhatsApp** tamu (format `08xxxxxxxxxx`).
4. Klik **Generate Link**.
5. Salin link undangan, atau klik **Kirim via WhatsApp** untuk mengirim langsung ke tamu.

#### Default Password
Password default halaman `/generate` adalah:

```
ubah-password-ini
```

Nilai ini berasal dari variabel `GENERATE_PASSWORD` di file `.env` (fallback di `config/wedding.php`). **Ganti sebelum dipakai di produksi:**

```env
GENERATE_PASSWORD=password-rahasia-anda
```

Setelah mengubah `.env`, jalankan `php artisan config:clear`.

---

## Konfigurasi

### `config/wedding.php`
Semua data acara dikonfigurasi di sini:

- `name_order` — urutan nama mempelai (`bride_first` atau `groom_first`).
- `groom` / `bride` — nama lengkap, panggilan, orang tua, Instagram.
- `akad` / `resepsi` — hari, tanggal, jam, alamat, dan link Google Maps.
- `turut_mengundang` — daftar keluarga yang mengundang.
- `generate_password` — password halaman generator.
- `og` — judul, deskripsi, dan gambar untuk Open Graph.

### Variabel `.env` terkait

```env
APP_URL=http://localhost:8000
GENERATE_PASSWORD=ubah-password-ini
WEDDING_NAME_ORDER=bride_first
```

### Aset
Letakkan aset di `public/`:
- `public/audio/background.mp3` — musik latar.
- `public/images/...` — gambar latar, ilustrasi, favicon, dsb.

> Jika perubahan tampilan tidak muncul atau muncul error "Unable to locate file in Vite manifest", jalankan `npm run build` atau `npm run dev`.

---

## Route

| Method | URI | Nama | Keterangan |
| --- | --- | --- | --- |
| GET | `/` | `invitation` | Halaman undangan |
| POST | `/rsvp` | `rsvp.store` | Simpan RSVP & ucapan |
| GET | `/generate` | `generate.form` | Form generator |
| POST | `/generate/auth` | `generate.auth` | Login generator |
| POST | `/generate` | `generate.create` | Buat link undangan |
| POST | `/generate/logout` | `generate.logout` | Logout generator |

---

## Testing

```bash
composer test
```

atau

```bash
php artisan test
```

---

## Teknologi

- Laravel 13 · PHP 8.3
- Blade + Tailwind CSS 4 (Vite)
- GSAP + ScrollTrigger + Lenis (animasi)
- SQLite (default database)
