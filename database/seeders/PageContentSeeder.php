<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'page_slug' => 'home',
                'section_key' => 'hero',
                'version' => '1.0',
                'order' => 1,
                'title' => 'Tumbuhkan Bisnis Anda Bersama Sollu POS',
                'subtitle' => 'Sistem kasir pintar untuk UMKM.',
                'is_active' => true,
                'attributes' => json_encode(['button_text' => 'Coba Sekarang', 'button_url' => '/trial']),
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'features',
                'version' => '1.0',
                'order' => 2,
                'title' => 'Fitur Unggulan',
                'subtitle' => 'Kami memiliki semua yang Anda butuhkan.',
                'is_active' => true,
                'attributes' => json_encode([
                    'features_list' => [
                        [
                            'title' => 'Kasir Digital Mobile',
                            'description' => 'Proses transaksi dari smartphone atau tablet dalam hitungan detik. Ringan, responsif, dan mudah digunakan kasir.',
                            'icon' => 'Smartphone'
                        ],
                        [
                            'title' => 'Analitik Akurat',
                            'description' => 'Pantau produk terlaris, jam sibuk, dan keuntungan bersih secara live melalui grafik laporan yang intuitif.',
                            'icon' => 'TrendingUp'
                        ],
                        [
                            'title' => 'Keamanan Data Terjamin',
                            'description' => 'Seluruh data penjualan dan pelanggan Anda tersimpan secara aman di server awan dengan enkripsi tinggi.',
                            'icon' => 'ShieldCheck'
                        ]
                    ]
                ]),
            ],
            [
                'page_slug' => 'services',
                'section_key' => 'hero',
                'version' => '1.0',
                'order' => 1,
                'title' => 'Solusi Disesuaikan untuk Bisnis Anda',
                'subtitle' => 'Sollu POS menyediakan fitur terdedikasi untuk industri F&B, Retail, dan Jasa. Tingkatkan efisiensi dan skala bisnis Anda.',
                'is_active' => true,
                'attributes' => null,
            ],
            [
                'page_slug' => 'pricing',
                'section_key' => 'hero',
                'version' => '1.0',
                'order' => 1,
                'title' => 'Investasi Transparan untuk Skala Bisnis',
                'subtitle' => 'Tanpa biaya tersembunyi. Pilih paket yang sesuai dengan ukuran bisnis Anda hari ini dan tingkatkan kapan saja.',
                'is_active' => true,
                'attributes' => null,
            ],
            [
                'page_slug' => 'contact',
                'section_key' => 'hero',
                'version' => '1.0',
                'order' => 1,
                'title' => 'Mari Ciptakan Solusi Bersama',
                'subtitle' => 'Tim kami siap membantu Anda memilih paket yang tepat atau memandu Anda dalam menggunakan Sollu POS di hari pertama.',
                'is_active' => true,
                'attributes' => null,
            ]
        ];

        foreach ($contents as $content) {
            \App\Models\PageContent::updateOrCreate(
                ['page_slug' => $content['page_slug'], 'section_key' => $content['section_key'], 'version' => $content['version']],
                $content
            );
        }
    }
}
