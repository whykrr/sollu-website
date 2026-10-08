# Rule 01: Filosofi UX, Prinsip Pengguna & Standar Wording (Website)

## 1. Filosofi Inti & Tone of Voice
> **"Jangan membuat pengunjung bingung; pandu mereka menuju tujuan yang jelas (konversi)."**
> *(Website wajib cepat, informatif, dan mengarahkan pengunjung (visitor) ke tindakan tertentu (Call-to-Action). Bahasa persuasif, profesional namun ramah, to the point, dan SEO-friendly).*

---

## 2. 10 Prinsip Rekayasa Pengalaman Pengguna & Invarian Teknis

| No | Prinsip | Invarian Teknis Wajib |
| :--- | :--- | :--- |
| 1 | **Fast Loading (Performa)** | Optimasi gambar (WebP/AVIF), Lazy loading untuk konten bawah fold, minimalkan script render-blocking. CWV (LCP < 2.5s) adalah prioritas. |
| 2 | **Mobile-First Design** | Sebagian besar pengunjung berasal dari mobile. Pastikan tap target $\ge 44\text{px}$. Teks mudah dibaca tanpa zoom. |
| 3 | **Clear Call-to-Action (CTA)** | Tombol utama harus kontras dan memiliki pesan aksi yang eksplisit (`"Coba Gratis"`, `"Hubungi Kami"`). |
| 4 | **Sederhana & Elegan** | Hindari clutter (terlalu banyak elemen). Manfaatkan *white space* (ruang kosong) untuk fokus pembaca. |
| 5 | **Bahasa Persuasif & SEO** | Gunakan heading (H1, H2, H3) secara semantik. Kosakata yang fokus pada *benefit* pengguna, bukan sekadar *fitur*. |
| 6 | **Aksesibilitas (a11y)** | Gunakan alt-text pada gambar, kontras warna yang cukup, dan dukung navigasi keyboard. |
| 7 | **Feedback Instan pada Form** | Validasi inline pada form kontak/inquiry. Tampilkan pesan sukses ("Pesan Anda telah terkirim") segera setelah submit. |
| 8 | **Mencegah Kesalahan Form** | Proteksi dari spam (Google reCAPTCHA atau honeypot). Tampilkan pesan error yang solutif. |
| 9 | **Sistem Konsisten** | Gunakan design system yang baku untuk Tipografi, Warna, dan Spasi (Tailwind v4). |
| 10 | **Wording Profesional** | Sapaan ramah, informatif. Hindari istilah teknis yang tidak dipahami audiens umum. |

---

## 3. Matriks Standar UX Copywriting (Do's & Don'ts)

| Konteks | ❌ Dilarang (Kaku / Teknis / Lemah) | ✅ Gunakan (Persuasif, Jelas, Profesional) |
| :--- | :--- | :--- |
| **CTA Utama** | "Submit", "Klik Disini" | "Coba Gratis Sekarang", "Mulai Kelola Bisnismu" |
| **Pesan Error Form** | "Internal Server Error." | "Maaf, terjadi kendala teknis. Silakan coba beberapa saat lagi." |
| **Validasi Form** | "Email invalid." | "Format email sepertinya kurang tepat." |
| **Form Sukses** | "Data inserted." | "Terima kasih! Tim kami akan segera menghubungi Anda." |
| **Empty State (Blog/News)** | "No record found." | "Belum ada artikel saat ini. Pantau terus update dari kami!" |
