# Rule 03: PHP Enums SSOT & Otorisasi

## 1. PHP Enums sebagai Single Source of Truth (No Magic Strings)
- **Backend adalah Master:** Seluruh status, tipe kategori (misal: `InquiryStatus`, `ArticleCategory`), didefinisikan di `app/Enums/*.php`. Dilarang menggunakan *magic strings* di dalam kode.
- **Implementasi:** Gunakan backed enums (`enum Status: string`).
- **Distribusi ke Frontend:** 
  - Jika digunakan di Vue, kirimkan melalui Inertia Shared Props (HandleInertiaRequests) agar frontend bisa mengaksesnya tanpa hardcode.
- **Penggunaan di Vue (Inertia):**
  - Hindari hardcode opsi dropdown di Vue. Kirimkan opsi dari Controller/Enum.
  - *Anti-pattern:* `<option value="draft">Draft</option>`
  - *Correct:* Gunakan array iterasi dari backend.

---

## 2. Otorisasi (Authentication & Authorization)
Meskipun website publik, terdapat bagian yang mungkin memerlukan otentikasi (misal: halaman CMS Admin).

- **Authentication:** Gunakan Laravel Breeze / Jetstream atau sekadar fitur Auth bawaan Laravel untuk mengamankan halaman panel admin.
- **Authorization (Gates/Policies):** 
  - Jika ada hirarki peran (misal `admin` vs `editor`), gunakan standard Laravel Authorization (Gates/Policies).
  - Pengecekan di Controller: `Gate::authorize('update', $post);`
  - Pengecekan di Blade/Vue: Kirimkan shared property permissions ke frontend jika dibutuhkan untuk menyembunyikan tombol Edit/Delete.
  - Jangan gunakan logika `if ($user->role === 'admin')` langsung di mana-mana. Bungkus dalam Gate.
