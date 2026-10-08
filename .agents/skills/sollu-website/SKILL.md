---
name: sollu-website
description: >-
    Comprehensive standards and guidelines for Sollu Website (Laravel 12, PHP 8.2+, Vue 3, Inertia.js 2.0, Tailwind CSS v4).
    Covers Core Architecture, Backend (Controllers, Services, Models, FormRequests), Frontend (Vue 3, Forms), 
    and general conventions tailored for a marketing website context. MUST trigger whenever working on any Sollu Website features.
---

# Sollu Website Engineering Guidelines & Standards

Pedoman dan standar baku rekayasa perangkat lunak untuk project **Sollu Website**.

---

## 1. Core Architecture & Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+).
- **Frontend:** Vue 3 (Composition API `<script setup>`), Inertia.js 2.0.
- **Styling:** Tailwind CSS v4, Vite.
- **Database:** PostgreSQL (Supabase) - schema `website`.
- **Tidak Ada Multi-Tenant:** Berbeda dengan Sollu App (SaaS), website ini TIDAK menerapkan pembatasan data berdasarkan `business_id` atau `outlet_id`.

## 2. Backend Standards

- **Strict Types & PHP 8.2+:** Selalu gunakan strict typing, constructor property promotion, dan explicit return types.
- **Controller-Service-Model (CSM):**
  - **Controller:** Bertugas sebagai entry point (menerima request, validasi `FormRequest`, memanggil Service, return view/JSON).
  - **Service:** Seluruh core logic diletakkan di dalam folder `app/Services`. Dilarang menaruh business logic panjang di Controller.
  - **Model:** Digunakan untuk interaksi database, relasi, mutator, dan accessor. Gunakan `casts(): array` bawaan Laravel.
- **FormRequests:** Pisahkan validasi ke dalam `FormRequest` terpisah.
- **Enums:** Jika ada status (misal `InquiryStatus`), gunakan PHP Backed Enums sebagai Single Source of Truth.
- **Response Constants:** Jika ada `ResourceMessage` atau Flash Session yang terstandarisasi, gunakan constant, hindari magic strings.

## 3. Frontend Standards (Vue 3 & Inertia)

- **Komponen Fungsional:** Gunakan komponen presentasional (misal: UI Buttons, Form inputs) dari folder `@/Components/` jika tersedia.
- **Styling (Tailwind v4):** 
  - Gunakan class utilitas Tailwind (misal: `gap-4`, `flex`, `md:grid-cols-2`). 
  - Fokus pada performa CWV (LCP, INP).
  - Optimasi aset gambar (lazy load `loading="lazy"`) dan teks.
- **Form Handling:** Form (seperti *Contact Us*, *Inquiry*) wajib memproses feedback visual (disabled state saat loading, dan pesan sukses/error).
- **Design System:** Ikuti warna dan typography brand Sollu yang di-set up pada `tailwind.config.js` atau CSS root variables.

## 4. Wording & UX (Marketing Context)

- **SEO & Persuasif:** Teks pada halaman harus SEO-friendly, jelas, persuasif, dan mengarahkan user pada suatu tindakan (Call to Action).
- **Sederhana & Elegan:** Minimalis, clean, hindari error teknis yang terlihat oleh pengguna awam.

## 5. Development Workflow

- Gunakan `php artisan test` untuk memastikan fitur baru di-cover oleh test.
- Gunakan `vendor/bin/pint --dirty` untuk format kode PHP sebelum commit.
- Gunakan Conventional Commits saat melakukan commit (mengikuti rule `07-git-and-changelog.md`).
