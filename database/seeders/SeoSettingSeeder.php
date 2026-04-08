<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoSetting;

class SeoSettingSeeder extends Seeder
{
    public function run(): void
    {
        $seo = [
            [
                'page_slug' => 'home',
                'meta_title' => 'Sollu POS — Platform Kasir Digital Terbaik untuk UMKM Indonesia',
                'meta_description' => 'Sollu POS adalah aplikasi kasir digital #1 untuk bisnis F&B, Retail, dan Jasa. Kelola penjualan, stok, dan laporan secara real-time. Coba gratis sekarang!',
                'og_image_url' => null,
            ],
            [
                'page_slug' => 'services',
                'meta_title' => 'Layanan & Fitur — Sollu POS',
                'meta_description' => 'Sollu POS menyediakan solusi kasir digital terdedikasi untuk industri F&B, Retail, dan Jasa. Manajemen meja, barcode scanning, booking pelanggan, dan lainnya.',
                'og_image_url' => null,
            ],
            [
                'page_slug' => 'pricing',
                'meta_title' => 'Harga & Paket — Sollu POS',
                'meta_description' => 'Pilih paket Sollu POS yang sesuai kebutuhan bisnis Anda. Mulai dari Rp 149.000/bulan dengan fitur lengkap. Tanpa biaya tersembunyi.',
                'og_image_url' => null,
            ],
            [
                'page_slug' => 'contact',
                'meta_title' => 'Hubungi Kami — Sollu POS',
                'meta_description' => 'Hubungi tim Sollu POS untuk konsultasi gratis, demo produk, atau pertanyaan teknis. Kami siap membantu bisnis Anda bertumbuh.',
                'og_image_url' => null,
            ],
            [
                'page_slug' => 'blog',
                'meta_title' => 'Blog & Wawasan Bisnis — Sollu POS',
                'meta_description' => 'Kumpulan artikel, studi kasus, dan panduan praktis seputar bisnis F&B, retail, dan jasa untuk membantu UMKM berkembang.',
                'og_image_url' => null,
            ],
        ];

        foreach ($seo as $item) {
            SeoSetting::updateOrCreate(
                ['page_slug' => $item['page_slug']],
                $item
            );
        }
    }
}
