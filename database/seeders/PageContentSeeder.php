<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // HOME PAGE
            [
                'page_slug' => 'home',
                'section_key' => 'hero',
                'title' => 'Kelola Bisnis Lebih <span class="text-primary-600">Mudah & Cepat</span> dengan Sollu POS',
                'subtitle' => 'Tingkatkan penjualan dan pantau performa bisnis Anda secara real-time. Cocok untuk F&B, Retail, dan Jasa. Coba sekarang, gratis!',
                'content' => null,
                'attributes' => [
                    'button_text' => 'Coba Gratis Sekarang',
                    'button_url' => 'https://app.sollu.local/trial',
                ],
                'is_active' => true,
                'order' => 1
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'features',
                'title' => 'Fitur Lengkap untuk Semua Kebutuhan Bisnis',
                'subtitle' => 'Apapun jenis usaha Anda, Sollu POS dirancang fleksibel menyesuaikan kebutuhan dari hulu ke hilir produksi hingga transaksi.',
                'content' => null,
                'attributes' => [
                    'features_list' => [
                        [
                            'icon' => 'Smartphone',
                            'title' => 'Kasir Digital Mobile',
                            'description' => 'Proses transaksi dari smartphone atau tablet dalam hitungan detik. Ringan, responsif, dan mudah digunakan kasir.'
                        ],
                        [
                            'icon' => 'TrendingUp',
                            'title' => 'Analitik Akurat',
                            'description' => 'Pantau produk terlaris, jam sibuk, dan keuntungan bersih secara live melalui grafik laporan yang intuitif.'
                        ],
                        [
                            'icon' => 'ShieldCheck',
                            'title' => 'Keamanan Data Terjamin',
                            'description' => 'Seluruh data penjualan dan pelanggan Anda tersimpan secara aman di server awan dengan enkripsi tinggi.'
                        ]
                    ]
                ],
                'is_active' => true,
                'order' => 2
            ],

            // SERVICES PAGE
            [
                'page_slug' => 'services',
                'section_key' => 'hero',
                'title' => 'Solusi Disesuaikan untuk Bisnis Anda',
                'subtitle' => 'Sollu POS menyediakan fitur terdedikasi untuk industri F&B, Retail, dan Jasa. Tingkatkan efisiensi dan skala bisnis Anda.',
                'content' => null,
                'attributes' => [],
                'is_active' => true,
                'order' => 1
            ],
            [
                'page_slug' => 'services',
                'section_key' => 'fnb',
                'title' => 'Manajemen Restoran Lebih Cerdas',
                'subtitle' => null,
                'content' => null,
                'attributes' => [
                    'image_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'button_url' => 'https://app.sollu.local/trial',
                    'features_list' => [
                        ['title' => 'Manajemen Meja & Dine-in', 'description' => 'Visualisasi tata letak meja untuk mengelola pesanan pelanggan secara langsung.'],
                        ['title' => 'Resep & Inventori Bahan Baku', 'description' => 'Pemotongan stok bahan otomatis untuk setiap produk terjual sehingga HPP terjaga.'],
                        ['title' => 'Kitchen Display System (KDS)', 'description' => 'Kirim pesanan secara digital ke dapur untuk mencegah miskomunikasi koki.']
                    ]
                ],
                'is_active' => true,
                'order' => 2
            ],
            [
                'page_slug' => 'services',
                'section_key' => 'retail',
                'title' => 'Kelola Stok & SKU Ribuan Item',
                'subtitle' => null,
                'content' => null,
                'attributes' => [
                    'image_url' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'button_url' => 'https://app.sollu.local/trial',
                    'features_list' => [
                        ['title' => 'Barcode Scanning', 'description' => 'Input penjualan super cepat menggunakan pemindai barcode atau kamera device.'],
                        ['title' => 'Peringatan Stok Tipis', 'description' => 'Notifikasi otomatis jika barang hampir habis untuk re-stock lebih terencana.'],
                        ['title' => 'Multi Cabang Gudang', 'description' => 'Lacak perpindahan stok antar toko dan terpusat dalam satu dashboard.']
                    ]
                ],
                'is_active' => true,
                'order' => 3
            ],
            [
                'page_slug' => 'services',
                'section_key' => 'jasa',
                'title' => 'Kenyamanan Pelanggan Jasa Anda',
                'subtitle' => null,
                'content' => null,
                'attributes' => [
                    'image_url' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'button_url' => 'https://app.sollu.local/trial',
                    'features_list' => [
                        ['title' => 'Penjadwalan (Booking) Booking', 'description' => 'Atur jadwal layanan pelanggan dan karyawan tanpa khawatir bentrok.'],
                        ['title' => 'Sistem Komisi Karyawan', 'description' => 'Perhitungan bagi hasil otomatis untuk setiap pegawai layanan.'],
                        ['title' => 'Member Loyalty', 'description' => 'Simpan riwayat transaksi pelanggan untuk retensi dan program loyalitas.']
                    ]
                ],
                'is_active' => true,
                'order' => 4
            ],

            // PRICING PAGE
            [
                'page_slug' => 'pricing',
                'section_key' => 'hero',
                'title' => 'Investasi Transparan untuk Skala Bisnis',
                'subtitle' => 'Tanpa biaya tersembunyi. Pilih paket yang sesuai dengan ukuran bisnis Anda hari ini dan tingkatkan kapan saja.',
                'content' => null,
                'attributes' => [],
                'is_active' => true,
                'order' => 1
            ],
            [
                'page_slug' => 'pricing',
                'section_key' => 'pricing_plans',
                'title' => null,
                'subtitle' => null,
                'content' => null,
                'attributes' => [
                    'plans' => [
                        [
                            'name' => 'Basic',
                            'price' => 'Rp 149.000',
                            'period' => '/ bulan',
                            'description' => 'Cocok untuk toko kecil atau kedai satu cabang yang baru mulai digitalisasi.',
                            'is_popular' => false,
                            'features' => ['1 Outlet & 1 Kasir', 'Manajemen Stok Dasar', 'Laporan Penjualan Harian', 'Dukungan Chat & Email']
                        ],
                        [
                            'name' => 'Profesional',
                            'price' => 'Rp 299.000',
                            'period' => '/ bulan',
                            'description' => 'Standar industri untuk restoran dan toko retail dengan mobilitas tinggi.',
                            'is_popular' => true,
                            'features' => ['Hingga 3 Outlet', 'Manajemen Stok & Resep', 'Laporan Analitik Lengkap', 'Manajemen Karyawan & Komisi', 'Dukungan Prioritas 24/7']
                        ],
                        [
                            'name' => 'Enterprise',
                            'price' => 'Hubungi Kami',
                            'period' => '',
                            'description' => 'Solusi custom untuk bisnis skala besar dengan kebutuhan intergrasi khusus.',
                            'is_popular' => false,
                            'features' => ['Outlet Tak Terbatas', 'Custom Integrasi API', 'Dedicated Account Manager', 'SLA Keamanan & Uptime', 'On-Premise Server (Opsional)']
                        ]
                    ]
                ],
                'is_active' => true,
                'order' => 2
            ],

            // CONTACT PAGE
            [
                'page_slug' => 'contact',
                'section_key' => 'hero',
                'title' => 'Mari Ciptakan Solusi Bersama',
                'subtitle' => 'Tim kami siap membantu Anda memilih paket yang tepat atau memandu Anda dalam menggunakan Sollu POS di hari pertama.',
                'content' => null,
                'attributes' => [],
                'is_active' => true,
                'order' => 1
            ]
        ];

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                [
                    'page_slug' => $content['page_slug'],
                    'section_key' => $content['section_key']
                ],
                $content
            );
        }
    }
}
