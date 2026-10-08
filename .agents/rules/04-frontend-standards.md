# Rule 04: Standar Antarmuka Frontend (Website)

## 1. Desain Publik & Performa (Web Vitals)
- **Performa adalah Fitur:** Website publik harus cepat. Prioritaskan LCP (Largest Contentful Paint) dan CLS (Cumulative Layout Shift) yang rendah.
- **Lazy Loading & Optimasi Gambar:** Semua gambar di bawah fold harus memiliki atribut `loading="lazy"`. Gunakan format WebP atau AVIF.
- **Font & Layout Shift:** Preload font utama untuk mencegah *Flash of Unstyled Text* (FOUT) dan lonjakan layout.

---

## 2. Struktur Komponen (Vue 3 + Inertia)
- **Komponen Presentasional vs Container:**
  - Buat komponen kecil yang dapat digunakan kembali (misalnya: `ButtonPrimary.vue`, `SectionHeading.vue`, `CardArticle.vue`).
  - Halaman Inertia (`Pages/`) bertindak sebagai container yang mengambil data dari props dan mendistribusikannya ke komponen presentasional.
- **Dilarang Inline CSS:** Gunakan class utilitas Tailwind CSS. Jika class terlalu panjang dan sering dipakai, ekstrak menggunakan komponen Vue, jangan menggunakan `@apply` di file CSS (karena kita menggunakan Tailwind v4 yang menyarankan komponen framework daripada custom CSS).

---

## 3. Form Publik (Contact, Inquiry, Newsletter)
- **Validasi Ganda:** Lakukan validasi di sisi client (UX instan) dan wajib validasi ketat di sisi server (Security).
- **Feedback Visual:** Form wajib menangani state *processing* (disable tombol submit, tampilkan loader) dan *error* (tampilkan pesan error tepat di bawah field input yang bermasalah).
- **Anti-Spam:** Lindungi form publik dari bot spam (contoh: gunakan Honeypot field yang disembunyikan via CSS, atau reCAPTCHA).

---

## 4. Responsivitas & Tipografi
- **Mobile-First:** Selalu mulai desain untuk viewport kecil (mobile) terlebih dahulu, baru gunakan utility modifier (`sm:`, `md:`, `lg:`) untuk layar yang lebih besar.
- **Area Sentuh (Touch Target):** Pada perangkat mobile, pastikan elemen interaktif (tombol, tautan di menu) memiliki ukuran minimal $44\times 44\text{px}$.
- **Keterbacaan Teks:** Hindari teks terlalu kecil di mobile. Pastikan kontras warna antara teks dan background memenuhi standar aksesibilitas (WCAG AA).

---

## 5. Rich Text Editor (Tiptap)
Untuk halaman artikel/blog atau konten dinamis yang menggunakan HTML renderer:
- Gunakan Tiptap untuk pengeditan konten di CMS.
- Konten HTML yang di-render di halaman publik wajib dibungkus dengan komponen `Prose` atau class `.prose` dari `@tailwindcss/typography` (jika menggunakan plugin tersebut) untuk memastikan styling elemen HTML standar (h1, p, ul, blockquote) konsisten.
