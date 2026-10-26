# Issue: Redesign Visual Undangan — Amplop Animasi, Asset Watercolor, Burung Hidup

> Dokumen ini adalah rencana kerja untuk junior programmer / AI model.
> Kerjakan **berurutan per fase**. Jangan lompat fase. Setiap fase punya checklist "Selesai jika".
> Jika ada yang ambigu, **tanya dulu**, jangan menebak.

---

## 0. Ringkasan Permintaan

1. Tampilan lebih "wah". Layar pertama (yang diklik) diganti menjadi **amplop yang terbuka dengan animasi**.
2. Ganti semua asset jelek (hutan SVG segitiga, karakter SVG, dll) dengan **asset PNG gratis bergaya watercolor**. Setiap asset harus dicek kecocokannya (gaya, lisensi, ukuran).
3. Ganti burung dengan burung yang **lebih realistis (sprite sheet PNG)** dan beri **gerakan ketika user sampai pada suatu section**, supaya website terasa hidup.

## 1. Keputusan Desain (sudah disetujui, jangan diubah)

| Topik | Keputusan |
|---|---|
| Gaya visual | **Watercolor / ilustrasi cat air** untuk semua asset (hutan, bunga, burung, daun). Satu gaya, jangan dicampur dengan kartun/flat/foto. |
| Palet | **Tetap biru** (`wedding-sky #E3F2FD` s/d `wedding-navy #0D47A1`) + **aksen emas** `wedding-gold #C9A227`. Sudah ada di `resources/css/app.css` (`@theme`). |
| Amplop | Dibangun dengan **HTML/CSS + GSAP** (bukan Lottie). Tekstur kertas & segel lilin pakai PNG. |
| Burung | **Sprite sheet PNG** (frame kepak sayap) + digerakkan **GSAP MotionPathPlugin** saat section masuk viewport. |

## 2. Kondisi Kode Saat Ini (baca dulu sebelum mulai)

| File | Isi / Masalah |
|---|---|
| `resources/views/invitation.blade.php` | Halaman utama. Baris 4–15: overlay pembuka (`#entry-overlay`) berisi Lottie amplop. Baris 23–26: dekorasi global. Baris 28–45: urutan section. |
| `resources/views/layouts/app.blade.php` | Load library via CDN: GSAP 3.12.5, ScrollTrigger, MotionPathPlugin, Lenis, lottie-web. **Tidak perlu menambah library baru.** |
| `resources/css/app.css` | Tailwind v4 `@theme`, class `.entry-overlay`, `.bird`, `.light-ray`, dll. |
| `public/js/invitation.js` | `initEntryOverlay()` (baris 35–83): klik overlay ⇒ play musik ⇒ play Lottie ⇒ fade out. |
| `public/js/birds.js` | Burung Lottie buatan sendiri (placeholder). Section `#scene-couple` **tidak ada** (id sebenarnya `#scene-couple-intro`), jadi satu burung tidak pernah muncul. |
| `public/js/scroll-narrative.js` | Lenis smooth scroll, parallax `[data-parallax]`, animasi gerbang, karakter, `.reveal`. |
| `public/js/decorations.js` | Canvas daun jatuh & partikel (bentuk elips polos). |
| `public/lottie/*.json` | Lottie placeholder buatan sendiri (jelek). Akan dihapus. |
| `resources/views/components/sections/opening-forest.blade.php` | Hutan dari SVG segitiga. **Diganti PNG.** |
| `resources/views/components/sections/gate.blade.php` | Gerbang SVG garis. **Diganti PNG** gerbang/arch bunga. |
| `resources/views/components/sections/characters.blade.php` | Karakter SVG kasar bolak-balik melintas layar. **Diganti ilustrasi PNG pasangan.** |
| `resources/views/components/decorations/bird-lottie.blade.php` | Tidak dipakai di mana pun. Boleh dihapus. |
| `tests/Feature/InvitationTest.php` | Test yang harus tetap lulus. |

Daftar id section (urut): `scene-forest`, `scene-gate`, `scene-characters`, `scene-bismillah`, `scene-greeting`, `scene-couple-intro`, `scene-groom`, `scene-bride`, `scene-akad`, `scene-resepsi`, `scene-countdown`, `scene-turut-mengundang`, `scene-gallery`, `scene-rsvp`, `scene-gift`, `scene-closing`.

### Bug yang ditemukan (perbaiki sekalian)
- [ ] `public/audio/background.mp3` **tidak ada** di repo. Musik tidak akan pernah bunyi. Minta file musik ke owner, atau cari musik bebas royalti (lihat Fase 1).
- [ ] `birds.js` memakai selector `#scene-couple` yang tidak ada (akan diganti total di Fase 4).
- [ ] Session `invitation_opened` dicek di `invitation.blade.php` tapi tidak pernah di-set. Biarkan saja (amplop selalu muncul = perilaku yang benar untuk undangan). Hapus `@if` tersebut agar tidak membingungkan.

## 3. Aturan Umum (WAJIB)

1. **Jangan tambah dependency** npm/composer. Semua yang dibutuhkan sudah ada (GSAP + ScrollTrigger + MotionPathPlugin + Lenis via CDN, Tailwind v4).
2. **Hapus** `lottie-web` dari `layouts/app.blade.php` setelah amplop & burung tidak lagi memakai Lottie.
3. JS ditulis di `public/js/*.js` dengan pola IIFE yang sudah ada (`(function () { 'use strict'; ... })();`). Jangan pindah ke Vite/module.
4. Selalu hormati `prefers-reduced-motion: reduce` ⇒ tanpa animasi besar, konten langsung terlihat.
5. **Mobile first**. Mayoritas tamu buka dari WhatsApp di HP. Test di lebar 360px dan 414px dulu, baru desktop.
6. Semua elemen dekoratif: `aria-hidden="true"` dan `pointer-events-none`. Semua `<img>` dekoratif: `alt=""`.
7. Semua asset di `public/images/...`, dipanggil dengan `{{ asset('images/...') }}`.
8. Setelah ubah file PHP/Blade: jalankan `vendor/bin/pint --dirty --format agent` dan `php artisan test --compact`.
9. Setelah ubah CSS: `npm run build` (atau `npm run dev` saat development).
10. Folder ini **bukan git repo**. Sebelum mulai, backup folder atau jalankan `git init` dan commit kondisi awal supaya bisa rollback.

---

## Fase 1 — Cari, Validasi, dan Siapkan Asset

### 1.1 Daftar asset yang dibutuhkan

| # | Nama file target | Isi | Ukuran maks (setelah kompres) |
|---|---|---|---|
| A1 | `images/forest/sky.webp` | Langit watercolor biru lembut (boleh JPG/WebP, tidak perlu transparan) | 250 KB |
| A2 | `images/forest/trees-far.webp` | Siluet pohon jauh, biru pucat, transparan | 200 KB |
| A3 | `images/forest/trees-mid.webp` | Pohon lapis tengah, transparan | 250 KB |
| A4 | `images/forest/trees-left.webp` | Pohon/dedaunan foreground kiri (frame tepi), transparan | 200 KB |
| A5 | `images/forest/trees-right.webp` | Pohon/dedaunan foreground kanan (boleh mirror dari A4 via CSS `scale-x-[-1]`) | 200 KB |
| A6 | `images/forest/mist.webp` | Kabut putih transparan | 100 KB |
| A7 | `images/gate/floral-arch.webp` | Gerbang/arch bunga watercolor biru-putih, transparan | 250 KB |
| A8 | `images/couple/couple.webp` | Ilustrasi pasangan pengantin watercolor (pakaian muslim/adat jika ada), transparan | 250 KB |
| A9 | `images/floral/corner-top-left.webp` | Ornamen bunga sudut (dipakai ulang di banyak section, mirror via CSS) | 150 KB |
| A10 | `images/floral/divider.webp` | Ornamen bunga horizontal pembatas section | 80 KB |
| A11 | `images/envelope/paper.webp` | Tekstur kertas cream/biru muda (tileable) | 80 KB |
| A12 | `images/envelope/wax-seal.webp` | Segel lilin (emas/biru) transparan | 60 KB |
| A13 | `images/envelope/flowers.webp` | Bunga watercolor yang menempel di amplop | 120 KB |
| A14 | `images/birds/dove-sprite.webp` | **Sprite sheet** burung (merpati/burung kecil) kepak sayap, minimal 6 frame, **satu baris horizontal**, ukuran frame seragam | 150 KB |
| A15 | `images/leaves/leaf-1..4.webp` | 3–4 kelopak/daun watercolor kecil untuk partikel jatuh | 20 KB per file |
| A16 | `audio/background.mp3` | Musik instrumental romantis | 3 MB |

Total gambar target: **< 2,5 MB**. Jika lewat, kompres ulang.

### 1.2 Sumber asset gratis (cek lisensi setiap file!)

| Situs | Lisensi umum | Catatan |
|---|---|---|
| pixabay.com | Pixabay License (bebas komersial, tanpa atribusi) | **Prioritas pertama.** Filter: Illustrations / Vector, kata kunci di bawah. |
| freepik.com | Free license (wajib atribusi) | Banyak watercolor wedding. Catat atribusi di `ATTRIBUTION.md`. |
| vecteezy.com | Free license (wajib atribusi) | Filter "Free License". |
| rawpixel.com | Pilih yang **CC0 / Public Domain** | Ilustrasi burung vintage/botanical cocok untuk gaya watercolor. |
| opengameart.org | CC0 / CC-BY | Untuk **sprite sheet burung**. Filter lisensi CC0. |
| itch.io (asset gratis) | Bervariasi, baca halaman lisensi | Cari "bird sprite sheet free". |
| pixabay.com/music | Pixabay License | Untuk musik latar. |

Kata kunci pencarian:
- Hutan: `watercolor forest png`, `watercolor pine trees transparent`, `blue watercolor forest silhouette`, `watercolor misty forest`.
- Bunga/ornamen: `watercolor blue flowers corner png`, `watercolor floral arch wedding`, `watercolor eucalyptus frame`.
- Pasangan: `watercolor muslim wedding couple`, `watercolor bride groom illustration`.
- Amplop: `wax seal png`, `paper texture watercolor`, `watercolor envelope`.
- Burung: `dove flying sprite sheet`, `bird flap animation sprite`, `bird flying frames png`.
  Jika sprite watercolor tidak ada: ambil sprite sheet realistis (CC0), lalu samakan tone warnanya (lihat 1.4).
- Musik: `romantic piano wedding`, `acoustic wedding instrumental`.

> Jangan pernah ambil dari Pinterest, Google Images, atau situs tanpa halaman lisensi jelas.

### 1.3 Checklist validasi per asset (isi untuk SETIAP file)

Perbarui `validate-assets.md` agar memuat bagian PNG/WebP berikut, lalu isi per file:

- [ ] **Lisensi**: bebas komersial. URL sumber & nama author dicatat.
- [ ] **Gaya**: watercolor, sama dengan asset lain (sapuan kuas lembut, tepi bleeding). Taruh semua asset berdampingan di satu halaman test; jika ada yang terlihat "beda sendiri", ganti.
- [ ] **Warna**: dominan biru/putih/hijau-kebiruan. Tidak ada merah/oranye mencolok (kecuali segel emas).
- [ ] **Transparansi**: background benar-benar transparan (buka di browser di atas background gelap, cek tidak ada kotak putih / halo).
- [ ] **Tidak ada watermark** atau teks.
- [ ] **Resolusi**: lebar minimal 1600px untuk layer full-width, 800px untuk ornamen, frame burung minimal 128px.
- [ ] **Ukuran file** sesuai tabel 1.1 setelah kompres.
- [ ] **Sprite sheet**: semua frame sama ukuran, satu baris, loop mulus (frame terakhir menyambung ke frame pertama).

### 1.4 Proses asset

1. Simpan file asli (PNG) di luar `public/` (misal `C:\Users\ReduceX\Documents\Data\wedding-assets-raw\`). Jangan commit file mentah.
2. Crop ruang kosong berlebih (tool gratis: photopea.com).
3. Jika warna tidak cocok: di Photopea pakai *Hue/Saturation* atau *Color Overlay* mode "Color" ke biru `#90CAF9`/`#1565C0`.
4. Konversi ke **WebP** (kualitas 80, alpha dipertahankan) di squoosh.app. Simpan dengan nama sesuai tabel 1.1.
5. Untuk sprite sheet: catat **jumlah frame**, **lebar frame**, **tinggi frame**. Ini dibutuhkan di Fase 4.
6. Update `public/lottie/ATTRIBUTION.md` ⇒ pindahkan ke `public/images/ATTRIBUTION.md` dengan format:
   ```
   ## forest/trees-mid.webp
   - Source: <URL>
   - Author: <nama>
   - License: <Pixabay License / Freepik Free / CC0 / ...>
   - Attribution required: <ya/tidak>
   ```
7. Jika ada asset yang wajib atribusi, tambahkan baris kecil kredit di `closing.blade.php` (font kecil, opacity rendah).

**Selesai jika:** semua file di tabel 1.1 ada, checklist 1.3 terisi untuk tiap file, ATTRIBUTION terisi, total ukuran gambar < 2,5 MB. **Tunjukkan screenshot semua asset berdampingan ke owner untuk approval sebelum lanjut Fase 2.**

---

## Fase 2 — Amplop Pembuka (Entry Overlay)

### 2.1 Alur yang diinginkan

1. Halaman dibuka ⇒ layar penuh latar biru watercolor (pakai `sky.webp` + blur) dengan **amplop di tengah**.
2. Di depan amplop: tulisan "Kepada Yth." + **nama tamu** (`$guestName`), segel lilin di tengah flap, tombol/teks "Buka Undangan" berkedip lembut.
3. Amplop melayang pelan naik-turun (idle float) sampai diklik.
4. Saat diklik/tap (atau tekan Enter/Spasi):
   1. Segel lilin membesar sedikit lalu memudar/pecah (0.4 dtk).
   2. Flap atas berputar terbuka 3D (`rotateX` 0 ⇒ -180°) (0.8 dtk).
   3. Kartu undangan (berisi "Dani & Desi" + tanggal) naik keluar dari amplop (0.9 dtk).
   4. Kartu membesar memenuhi layar, amplop turun & memudar (0.8 dtk).
   5. Overlay hilang, musik mulai, scroll diaktifkan, user langsung melihat `scene-forest`.
5. Total durasi ±3 detik. Jangan lebih dari 4 detik.

### 2.2 Struktur HTML

Buat komponen baru `resources/views/components/sections/envelope.blade.php` dan panggil di `invitation.blade.php` menggantikan blok baris 4–15 (hapus juga `@if session(...)`):

```blade
@props(['guestName'])

<div id="entry-overlay" class="entry-overlay" role="dialog" aria-modal="true" aria-label="Buka undangan">
    <img src="{{ asset('images/forest/sky.webp') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-70" aria-hidden="true">

    <button type="button" id="envelope" class="envelope" aria-label="Buka undangan untuk {{ $guestName }}">
        <span class="envelope-back"></span>
        <span class="envelope-card">
            <span class="font-elegant text-sm">The Wedding of</span>
            <span class="font-script text-4xl text-wedding-deep">Dani &amp; Desi</span>
            <span class="font-heading text-xs tracking-[0.3em]">28 . 11 . 2026</span>
        </span>
        <span class="envelope-front"></span>
        <span class="envelope-flap"></span>
        <img src="{{ asset('images/envelope/wax-seal.webp') }}" alt="" class="envelope-seal">
        <img src="{{ asset('images/envelope/flowers.webp') }}" alt="" class="envelope-flowers">
    </button>

    <div class="relative z-10 mt-8 text-center">
        <p class="font-elegant text-wedding-deep/70">Kepada Yth.</p>
        <p class="font-heading text-xl text-wedding-deep">{{ $guestName }}</p>
        <p class="envelope-hint mt-4 font-body text-sm text-wedding-gold">Ketuk amplop untuk membuka</p>
    </div>
</div>
```

Catatan:
- Pakai `<button>` supaya keyboard & screen reader bisa membuka (aksesibilitas, jangan dihapus).
- `{{ }}` sudah escape nama tamu. **Jangan pakai `{!! !!}`** (nama dari URL = input tidak tepercaya).
- Cek nilai default `$guestName` di `InvitationController::resolveGuestName()` agar tampil wajar saat tanpa token.

### 2.3 CSS (taruh di `resources/css/app.css`, ganti `.entry-overlay` lama)

Panduan (silakan sesuaikan angka):

```css
.entry-overlay { position: fixed; inset: 0; z-index: 100; display: flex; flex-direction: column;
    align-items: center; justify-content: center; overflow: hidden; background: var(--color-wedding-sky); }

.envelope { position: relative; width: min(82vw, 380px); aspect-ratio: 3 / 2; perspective: 1200px;
    cursor: pointer; border: 0; background: none; }
.envelope:focus-visible { outline: 2px solid var(--color-wedding-gold); outline-offset: 8px; }

.envelope-back, .envelope-front, .envelope-flap { position: absolute; inset: 0;
    background: url('/images/envelope/paper.webp') center / cover, #F5F9FF; }
.envelope-back  { border-radius: 6px; box-shadow: var(--shadow-card); }
.envelope-front { clip-path: polygon(0 0, 50% 55%, 100% 0, 100% 100%, 0 100%); z-index: 3; }
.envelope-flap  { clip-path: polygon(0 0, 100% 0, 50% 60%); transform-origin: top center;
    z-index: 4; backface-visibility: hidden; filter: brightness(0.97); }
.envelope-card  { position: absolute; inset: 8% 6%; z-index: 2; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: .25rem; background: #fff; border-radius: 4px;
    border: 1px solid color-mix(in srgb, var(--color-wedding-gold) 50%, transparent); }
.envelope-seal  { position: absolute; left: 50%; top: 55%; width: 22%; translate: -50% -50%; z-index: 5; }
.envelope-flowers { position: absolute; right: -12%; bottom: -14%; width: 55%; z-index: 6; pointer-events: none; }
```

- Bayangan, garis emas tipis, dan tekstur kertas membuat kesan mewah. Jangan pakai gradient warna-warni.
- Test di lebar 360px: amplop harus muat dan nama tamu terbaca.

### 2.4 JavaScript (`public/js/invitation.js`)

Ganti isi `initEntryOverlay()`. Hapus semua kode Lottie. Contoh timeline:

```js
function initEntryOverlay() {
    const overlay = document.getElementById('entry-overlay');
    const envelope = document.getElementById('envelope');
    if (!overlay || !envelope) { return; }

    document.body.classList.add('no-scroll');
    window.weddingLenis?.stop();

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const idle = reduced ? null : gsap.to(envelope, { y: -10, duration: 2, yoyo: true, repeat: -1, ease: 'sine.inOut' });

    envelope.addEventListener('click', () => {
        playMusic();
        idle?.kill();

        const finish = () => {
            overlay.remove();
            document.body.classList.remove('no-scroll');
            window.weddingLenis?.start();
            ScrollTrigger.refresh();
        };

        if (reduced) {
            gsap.to(overlay, { opacity: 0, duration: 0.4, onComplete: finish });
            return;
        }

        gsap.timeline({ onComplete: finish })
            .to('.envelope-hint', { opacity: 0, duration: 0.2 })
            .to('.envelope-seal', { scale: 1.3, opacity: 0, duration: 0.4, ease: 'back.in(2)' })
            .to('.envelope-flap', { rotateX: -180, duration: 0.8, ease: 'power2.inOut' }, '-=0.1')
            .set('.envelope-flap', { zIndex: 1 })
            .to('.envelope-card', { yPercent: -60, duration: 0.9, ease: 'power3.out' })
            .to('.envelope-card', { scale: 1.6, duration: 0.6, ease: 'power2.in' })
            .to(overlay, { opacity: 0, duration: 0.6 }, '-=0.3');
    }, { once: true });
}
```

Catatan penting:
- Urutan script di `invitation.blade.php`: `scroll-narrative.js` dibuat sebelum `invitation.js` (sudah benar) agar `window.weddingLenis` sudah ada.
- `playMusic()` harus dipanggil langsung di dalam handler klik (aturan autoplay browser).
- Hapus file `public/lottie/envelope-open.json`.

### 2.5 Test

Tambah satu test di `tests/Feature/InvitationTest.php`:

```php
public function test_envelope_shows_guest_name(): void
{
    $response = $this->get('/?g='.$this->encryptGuestName('Bapak Ahmad Surya'));

    $response->assertOk();
    $response->assertSee('id="envelope"', false);
    $response->assertSee('Bapak Ahmad Surya');
}
```

**Selesai jika:** amplop tampil di HP & desktop, terbuka mulus dengan klik/tap/Enter, nama tamu tampil (dan ter-escape), musik bunyi setelah klik, scroll aktif setelah amplop hilang, mode reduced-motion langsung fade, `php artisan test --compact` lulus.

---

## Fase 3 — Ganti Asset Hutan, Gerbang, Karakter, Ornamen

### 3.1 `opening-forest.blade.php`

- Hapus `<svg>` `#forest-pine` dan semua `<use>`.
- Ganti dengan layer `<img>` bertumpuk, masing-masing tetap punya `data-parallax` (sistem parallax di `scroll-narrative.js` sudah jalan otomatis):

| Layer | Asset | z-index | `data-parallax` |
|---|---|---|---|
| Langit | `sky.webp` (`object-cover`, full) | 0 | `0.1` |
| Pohon jauh | `trees-far.webp` (bawah, full width) | 10 | `0.3` |
| Kabut | `mist.webp` | 15 | `0.4` |
| Pohon tengah | `trees-mid.webp` | 18 | `0.55` |
| Foreground kiri | `trees-left.webp` (class `forest-foreground-left`) | 20 | `0.8` |
| Foreground kanan | `trees-right.webp` / mirror (class `forest-foreground-right`) | 20 | `0.8` |
| Teks judul | sudah ada | 30 | – |

- Pertahankan class `forest-foreground-left/right`: `scroll-narrative.js` menggesernya keluar layar saat scroll (efek "masuk ke hutan").
- Layer pertama (sky) pakai `fetchpriority="high"`; layer lain `decoding="async"`. **Jangan** `loading="lazy"` di section pertama.
- Tambah kabut bergerak pelan: GSAP `x: '+=40'`, `yoyo`, `repeat: -1`, 12 dtk.

### 3.2 `gate.blade.php`

- Ganti SVG gerbang dengan `floral-arch.webp` di dalam `#gate` (pertahankan id `#gate` dan `.gate-light` agar animasi zoom di `initGate()` tetap jalan).
- Pintu kiri/kanan (`.gate-door-left/right`) tidak lagi ada. Hapus dua `gsap.to('.gate-door-...')` di `scroll-narrative.js` **atau** ganti dengan dua `floral/corner` yang bergeser ke samping saat scroll (efek tirai bunga terbuka). Pilih opsi kedua jika waktu cukup.

### 3.3 `characters.blade.php`

- Hapus SVG pengantin dan animasi bolak-balik melintas layar (`initCharacters()` bagian bride/groom), karena terlihat murahan.
- Ganti dengan `couple.webp` di tengah/atas teks, animasi: masuk `opacity 0 ⇒ 1`, `y: 40 ⇒ 0`, dan "napas" pelan (`scale 1 ⇒ 1.02`, yoyo, 4 dtk).
- Kelopak `.petal` boleh dipertahankan jika ada.

### 3.4 Ornamen di section lain

- Buat komponen kecil `resources/views/components/ui/floral-corners.blade.php` yang menampilkan `corner-top-left.webp` di 2 sudut (kiri atas asli, kanan bawah `rotate-180`). Pakai di section: `bismillah`, `couple-intro`, `akad`, `resepsi`, `rsvp`, `closing`. `loading="lazy"`.
- Ganti isi `components/ui/section-divider.blade.php` dengan `<img>` `divider.webp` (lebar ±240px, tengah).

### 3.5 Daun jatuh (`decorations.js`)

- Ganti `context.ellipse(...)` dengan `context.drawImage(leafImg, ...)` memakai `leaf-1..4.webp` (pre-load dengan `new Image()`, mulai animasi setelah semua `onload`).
- Kurangi `count` ke 12 di layar < 768px untuk performa.
- Pause loop `requestAnimationFrame` saat `document.hidden` (hemat baterai).

**Selesai jika:** tidak ada lagi SVG pohon segitiga / karakter SVG / gerbang garis; semua diganti PNG/WebP watercolor; parallax tetap jalan; tidak ada gambar pecah/terpotong aneh di 360px dan 1440px.

---

## Fase 4 — Burung Sprite Sheet + Gerak per Section

### 4.1 Hapus yang lama

- Hapus `public/lottie/bird-flying.json`, `bird-pair.json`, folder `public/lottie/` (setelah ATTRIBUTION dipindah), `components/decorations/bird-lottie.blade.php`.
- Hapus `<script lottie...>` di `layouts/app.blade.php`.
- Kosongkan & tulis ulang `public/js/birds.js`.

### 4.2 Animasi kepak sayap (CSS sprite)

Di `app.css` (ganti `.bird` & `@keyframes flyAcross` lama). Contoh untuk sprite 8 frame @ 128×128 px (**sesuaikan dengan angka dari Fase 1.4 langkah 5**):

```css
.sprite-bird {
    position: absolute;
    width: 64px;                 /* tampil setengah ukuran frame agar tajam di layar retina */
    aspect-ratio: 1;
    background: url('/images/birds/dove-sprite.webp') 0 0 / 800% 100% no-repeat; /* 800% = 8 frame */
    animation: bird-flap 0.6s steps(7) infinite; /* steps = jumlah frame - 1 */
    pointer-events: none;
    will-change: transform;
}
@keyframes bird-flap { to { background-position: 100% 0; } }
@media (prefers-reduced-motion: reduce) { .sprite-bird { animation: none; } }
```

- Arah hadap burung: jika sprite menghadap kanan dan path ke kiri, tambah `scale-x: -1` lewat GSAP (`scaleX: -1`).
- Variasi: ukuran 40–72px, `animation-duration` 0.5–0.8 dtk agar burung tidak kompak seperti robot.

### 4.3 Gerak saat masuk section (`birds.js`)

Konsep: tiap section punya "momen burung". Saat section masuk viewport (`ScrollTrigger` `start: 'top 60%'`), burung dibuat, terbang mengikuti path (MotionPathPlugin), lalu dihapus dari DOM. Satu kali per section (`once: true`).

Konfigurasi (silakan sesuaikan):

| Section | Jumlah | Perilaku |
|---|---|---|
| `#scene-forest` | 3–4 | Kawanan terbang dari pohon kiri ke kanan atas, melengkung, saat halaman pertama tampil (trigger setelah amplop terbuka). |
| `#scene-gate` | 2 | Sepasang burung terbang keluar dari dalam gerbang menuju kamera (scale 0.4 ⇒ 1.4, opacity ⇒ 0). |
| `#scene-couple-intro` | 2 | Sepasang burung terbang dari dua sisi, bertemu di atas judul, lalu terbang bersama keluar atas. |
| `#scene-akad` / `#scene-resepsi` | 1 | Satu burung melintas pelan di latar belakang (opacity 0.6). |
| `#scene-closing` | 3–5 | Kawanan terbang menjauh ke langit (scale mengecil) sebagai penutup. |

Kerangka kode:

```js
(function () {
    'use strict';
    if (!window.gsap || !window.MotionPathPlugin) { return; }
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { return; }
    gsap.registerPlugin(ScrollTrigger, MotionPathPlugin);

    // path dalam satuan % dari ukuran section (dikonversi ke px saat dijalankan)
    const moments = [
        { section: '#scene-forest', count: 4, path: [[-10, 70], [30, 40], [70, 30], [110, 10]], duration: 7, size: [40, 64] },
        { section: '#scene-gate', count: 2, path: [[50, 55], [45, 35], [30, 0]], duration: 3.5, size: [48, 72], grow: true },
        // ... lanjutkan sesuai tabel
    ];

    function fly(moment) {
        const section = document.querySelector(moment.section);
        if (!section) { return; }
        const { width, height } = section.getBoundingClientRect();

        for (let i = 0; i < moment.count; i++) {
            const bird = document.createElement('div');
            bird.className = 'sprite-bird';
            bird.setAttribute('aria-hidden', 'true');
            bird.style.width = gsap.utils.random(moment.size[0], moment.size[1]) + 'px';
            bird.style.animationDuration = gsap.utils.random(0.5, 0.8) + 's';
            bird.style.zIndex = 25;
            section.appendChild(bird);

            const jitter = () => gsap.utils.random(-6, 6);
            const path = moment.path.map(([x, y]) => ({ x: (x + jitter()) / 100 * width, y: (y + jitter()) / 100 * height }));

            gsap.to(bird, {
                motionPath: { path, curviness: 1.4, autoRotate: false },
                scale: moment.grow ? 1.4 : 1,
                opacity: moment.grow ? 0 : 1,
                duration: moment.duration + gsap.utils.random(-0.8, 0.8),
                delay: i * gsap.utils.random(0.15, 0.4),
                ease: 'sine.inOut',
                onComplete: () => bird.remove(),
            });
        }
    }

    moments.forEach((moment) => {
        ScrollTrigger.create({ trigger: moment.section, start: 'top 60%', once: true, onEnter: () => fly(moment) });
    });
})();
```

Hal yang harus diperhatikan:
- Section yang memasang burung harus punya `relative overflow-hidden` (cek class tiap section; tambahkan jika belum).
- `#scene-forest` sudah terlihat sejak awal (di belakang amplop). Agar burungnya tidak terbang sia-sia di balik amplop, panggil `fly()` untuk forest dari `invitation.js` setelah amplop selesai: misal `window.dispatchEvent(new Event('invitation:opened'))` di `finish()`, lalu di `birds.js` dengarkan event itu untuk momen forest.
- Maksimal ±6 burung tampil bersamaan (performa HP murah).
- Burung **tidak boleh menutupi teks penting** terlalu lama. Path lewat area kosong/atas.

### 4.4 Burung ambient (opsional, kerjakan terakhir)

- 1–2 burung kecil (32px, opacity 0.4) terbang melintas sesekali (interval acak 15–30 dtk) di layer `position: fixed` agar halaman tidak pernah terasa "mati". Pause saat `document.hidden`.

**Selesai jika:** burung realistis mengepak sayap mulus, terbang melengkung saat setiap section di tabel 4.3 masuk viewport, dihapus dari DOM setelah selesai, tidak ada error console, tidak ada Lottie tersisa.

---

## Fase 5 — Membuat Section Lebih Hidup (Micro Motion)

Gunakan class/sistem yang sudah ada (`.reveal`, `.stagger-children` di `scroll-narrative.js`). Tambahkan hanya yang di tabel ini:

| Section | Gerakan |
|---|---|
| `scene-bismillah` | Teks Arab muncul dengan `clip-path` dari tengah ke samping + glow emas tipis. |
| `scene-greeting` | Nama tamu muncul huruf demi huruf (split per karakter manual dengan `<span>`; tidak perlu plugin SplitText). |
| `scene-groom` / `scene-bride` | Foto/frame masuk dari samping (groom dari kiri, bride dari kanan), ornamen sudut berputar pelan masuk. |
| `scene-akad` / `scene-resepsi` | Kartu info (`components/ui/info-card`) naik bergiliran (`stagger`), ikon bergoyang sekali. |
| `scene-countdown` | Angka "flip"/scale kecil tiap detik berganti (di `countdown.js`). |
| `scene-gallery` | Foto muncul dengan scale 0.9 ⇒ 1 + stagger. |
| `scene-closing` | Ornamen bunga tumbuh dari bawah (`scaleY 0 ⇒ 1`, `transform-origin: bottom`), lalu kawanan burung (Fase 4). |
| Semua ornamen sudut | Goyang pelan seperti tertiup angin: `rotation: ±2`, yoyo, 4–6 dtk, `transform-origin` di pangkal. |

Aturan: animasi masuk ≤ 1,2 dtk, easing `power2.out` / `power3.out`, tidak ada animasi berulang yang mencolok di area teks.

**Selesai jika:** setiap section punya minimal satu gerakan saat masuk, tidak ada yang terasa berlebihan/pusing, reduced-motion mematikan semuanya.

---

## Fase 6 — Polish Visual "Wah"

- [ ] Aksen emas: garis tipis 1px emas di kartu (`.wedding-card` border `wedding-gold/40`), judul section diberi ornamen emas kecil.
- [ ] Ganti `title-gradient` agar ada sedikit kilau emas (gradient biru tua ⇒ emas sangat halus), jangan berlebihan.
- [ ] Latar section bergantian: sebagian pakai tekstur kertas watercolor (`paper.webp`, opacity 0.3) agar tidak flat biru semua.
- [ ] Hapus `.light-ray` jika setelah asset baru terlihat mengganggu (cek visual dulu).
- [ ] Tombol (RSVP, share, gift): rounded-full, border emas tipis, hover sedikit naik.
- [ ] Konsistensi font: judul `font-script`, sub judul `font-heading`, isi `font-body`. Jangan tambah font baru.
- [ ] Bandingkan dengan 3 referensi undangan digital premium (cari "undangan digital watercolor" / "wedding invitation website parallax"), catat 3 hal yang mau ditiru, tunjukkan ke owner.

---

## Fase 7 — Performa & QA

### Performa
- [ ] Total transfer halaman pertama (sebelum scroll) < 1,5 MB. Cek di DevTools Network, "Disable cache", throttle "Fast 4G".
- [ ] Gambar di bawah fold pakai `loading="lazy"`.
- [ ] Preload gambar amplop & sky di `<head>` (`<link rel="preload" as="image" href="...">`) lewat `@push` atau langsung di layout.
- [ ] Lighthouse mobile: Performance ≥ 70, Accessibility ≥ 90.
- [ ] Tidak ada jank saat scroll di HP Android kelas menengah (test langsung di HP, bukan hanya emulator).

### QA Checklist
- [ ] Chrome Android, Safari iOS, Chrome desktop, Firefox desktop.
- [ ] Buka dari link WhatsApp (in-app browser) — amplop & musik jalan.
- [ ] Tanpa token `?g=` ⇒ nama default tampil wajar.
- [ ] Nama tamu panjang (contoh: "Bapak Haji Muhammad Abdurrahman Siregar beserta keluarga") tidak merusak layout amplop.
- [ ] Nama berisi karakter HTML (`<b>tes</b>`) tampil sebagai teks, bukan HTML.
- [ ] Reduced motion (DevTools ⇒ Rendering ⇒ emulate `prefers-reduced-motion`) ⇒ tidak ada animasi besar, konten tetap terlihat.
- [ ] Keyboard: Tab ke amplop, Enter membuka.
- [ ] Console: 0 error, 0 404 asset.
- [ ] `php artisan test --compact` lulus, `vendor/bin/pint --dirty --format agent` dijalankan, `npm run build` sukses.

---

## Definition of Done (keseluruhan)

1. Layar pembuka = amplop animasi HTML/CSS+GSAP dengan nama tamu, berfungsi di HP & desktop.
2. Tidak ada lagi asset placeholder (SVG segitiga, karakter SVG, Lottie buatan sendiri). Semua asset watercolor, satu gaya, lisensi tercatat di `public/images/ATTRIBUTION.md`.
3. Burung sprite sheet realistis bergerak saat masuk section sesuai tabel Fase 4.3.
4. Setiap section punya micro motion (Fase 5).
5. Checklist Fase 7 semua tercentang.
6. Owner sudah approve: (a) kumpulan asset (akhir Fase 1), (b) amplop (akhir Fase 2), (c) hasil akhir.

## Urutan Pengerjaan & Estimasi

| Fase | Estimasi | Bergantung pada |
|---|---|---|
| 1. Asset | 1–2 hari | – |
| 2. Amplop | 1 hari | Fase 1 (paper, seal, flowers) |
| 3. Ganti asset section | 1 hari | Fase 1 |
| 4. Burung | 1 hari | Fase 1 (sprite) |
| 5. Micro motion | 0,5–1 hari | Fase 3 |
| 6. Polish | 0,5 hari | Fase 3–5 |
| 7. QA | 0,5 hari | semua |

## Pertanyaan Terbuka (tanyakan ke owner sebelum/selama pengerjaan)

1. File musik latar: sudah ada lagu pilihan, atau cari dari Pixabay Music?
2. Ilustrasi pasangan (A8): pakaian muslim modern, adat (Batak/Melayu/Jawa), atau siluet saja?
3. Foto asli pasangan untuk `groom`, `bride`, `gallery`: sudah ada? Format & jumlah?
4. Boleh ada kredit atribusi kecil di footer jika asset gratis mewajibkannya?
