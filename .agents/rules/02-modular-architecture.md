# Rule 02: Arsitektur Website & Pembagian Logic

## 1. Controller-Service-Model (CSM) Architecture
Aplikasi website ini (yang tidak sekompleks sistem SaaS) tetap harus rapi dan modular menggunakan pola arsitektur **Controller-Service-Model**:

- **Controller (`App\Http\Controllers\`):**
  - Hanya bertugas menerima request HTTP, melakukan validasi (via `FormRequest`), memanggil Service, dan mengembalikan Response (Inertia view atau JSON).
  - **Dilarang keras** meletakkan logika bisnis (seperti pengiriman email kompleks, integrasi pihak ketiga, kalkulasi) di dalam Controller.
  
- **Service (`App\Services\`):**
  - Bertanggung jawab atas inti logika bisnis aplikasi.
  - Contoh: `ContactMessageService`, `NewsletterSubscriptionService`.
  - Service harus dapat di-test secara independen.

- **Model (`App\Models\`):**
  - Hanya mengurus interaksi dengan database (Eloquent), relasi, scope, dan mutator/accessor.

---

## 2. Struktur Modul & Fitur (Jika Aplikasi Membesar)
Meskipun aplikasi website umumnya statis, fitur-fitur interaktif dikelompokkan ke dalam domain yang jelas:
- `CMS` (untuk manajemen konten seperti Blog, Halaman).
- `Marketing` (untuk leads, inquiry, contact us).
- `Settings` (pengaturan website global).

---

## 3. 🚨 Larangan Keras (Anti-Patterns)
- **God Controller / God Service:** Dilarang membuat class yang mengatur terlalu banyak hal berbeda (misal `WebsiteController` yang mengurus Blog, Kontak, dan FAQ sekaligus). Pisahkan menjadi `BlogController`, `ContactController`, dll.
- **Fat Model:** Jangan letakkan bisnis logic panjang di dalam Model.
- **Raw SQL Queries:** Gunakan Eloquent semaksimal mungkin. Hindari `DB::raw()` kecuali performa benar-benar membutuhkan.

---

## 4. Keamanan & Performa Publik
1. **Rate Limiting:** Semua endpoint publik yang menerima input (Form Kontak, Newsletter) WAJIB dilindungi oleh Rate Limiter untuk mencegah spam.
2. **Caching:** Endpoint yang mengambil konten statis secara berat (contoh: list artikel populer) sebaiknya di-cache.
