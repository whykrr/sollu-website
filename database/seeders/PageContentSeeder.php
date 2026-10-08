<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // ==========================================
            // 1. HOME LANDING PAGE SECTIONS
            // ==========================================
            [
                'page_slug' => 'home',
                'section_key' => 'hero',
                'order' => 1,
                'title' => 'Kelola Bisnis Lebih <span class="text-primary-600">Mudah & Cepat</span> dengan Sollu POS',
                'subtitle' => 'Platform Point of Sale modern untuk bisnis F&B, Retail, dan Jasa. Terintegrasi kasir digital, manajemen stok otomatis, dan analitik penjualan real-time.',
                'content' => null,
                'attributes' => [
                    'badge' => 'Platform POS Pilihan 10.000+ UMKM',
                    'button_text' => 'Coba Gratis Sekarang',
                    'button_url' => 'https://app.sollu.local/trial',
                    'secondary_button_text' => 'Pelajari Fitur',
                    'secondary_button_url' => '#fitur',
                    'hero_image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'differentiators',
                'order' => 2,
                'title' => 'Kenapa Sollu POS Berbeda?',
                'subtitle' => 'Dirancang khusus untuk menyederhanakan operasional harian merchant dengan kecepatan transaksi tinggi, antarmuka intuitif, dan keandalan sistem tanpa kompromi.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Keunggulan Utama',
                    'stats' => [
                        [
                            'value' => '10k+',
                            'label' => 'Mitra Bisnis',
                        ],
                        [
                            'value' => '25+',
                            'label' => 'Fitur Unggulan',
                        ],
                        [
                            'value' => '99.9%',
                            'label' => 'Tingkat Uptime',
                        ],
                    ],
                    'items' => [
                        [
                            'title' => 'Kasir Kilat & Offline Mode',
                            'description' => 'Proses transaksi hitungan detik. Tetap lancar mencetak struk dan merekam transaksi meski jaringan internet terputus.',
                        ],
                        [
                            'title' => 'Manajemen Stok & HPP',
                            'description' => 'Pengurangan bahan baku otomatis untuk setiap produk terjual sehingga kalkulasi HPP selalu presisi dan minim selisih.',
                        ],
                        [
                            'title' => 'Multi Cabang Terintegrasi',
                            'description' => 'Pantau puluhan outlet dari satu dashboard pemilik. Transfer stok antargudang tercatat rapi secara real-time.',
                        ],
                        [
                            'title' => 'QRIS & Pembayaran Digital',
                            'description' => 'Terima pembayaran e-wallet dan kartu debit secara praktis dengan notifikasi pembayaran instan ke layar kasir.',
                        ],
                        [
                            'title' => 'Laporan Analitik Real-Time',
                            'description' => 'Analisis produk terlaris, jam paling sibuk, dan keuntungan bersih bisnis kapan saja langsung dari ponsel Anda.',
                        ],
                        [
                            'title' => 'Otorisasi & Absensi Kasir',
                            'description' => 'Bagi hak akses kasir, supervisor, dan owner secara aman. Lacak riwayat pembatalan transaksi (void) dan diskon staf.',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'showcase',
                'order' => 3,
                'title' => 'Semua Kendali Bisnis dalam Satu Sistem',
                'subtitle' => 'Gunakan layanan Sollu POS melalui tablet kasir di outlet, atau pantau laporan omzet dan pantau performa cabang langsung dari smartphone dan laptop Anda.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Fitur Unggulan',
                    'tagline' => 'Aplikasi Kasir & Backoffice Cloud',
                    'image_url' => '/img/showcase-devices.svg',
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'solutions',
                'order' => 4,
                'title' => 'Solusi Terdedikasi untuk Berbagai Sektor Usaha',
                'subtitle' => 'Setiap bisnis memiliki alur kerja unik. Sollu POS hadir dengan modul yang telah dioptimalkan untuk sektor F&B, Retail, dan Jasa.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Solusi Industri',
                    'tabs' => [
                        [
                            'id' => 'fnb',
                            'label' => 'Makanan & Minuman (F&B)',
                            'title' => 'Manajemen Restoran & Kafe Lebih Efisien',
                            'description' => 'Visualisasikan denah meja, teruskan pesanan ke printer dapur instan, dan pantau pemakaian stok bahan baku resep secara akurat.',
                            'image_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'features' => [
                                'Manajemen Meja, Dine-in & Takeaway',
                                'Resep Masakan & Potong Bahan Otomatis',
                                'Kitchen Display System (KDS) & Printer Dapur',
                                'Split Bill & Penggabungan Tagihan Meja',
                            ],
                        ],
                        [
                            'id' => 'retail',
                            'label' => 'Toko Retail & Butik',
                            'title' => 'Kelola Puluhan Ribu SKU Barang Tanpa Khawatir',
                            'description' => 'Input transaksi kasir super cepat dengan barcode scanner, sinkronisasi stok multi-cabang, serta peringatan stok menipis.',
                            'image_url' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'features' => [
                                'Barcode Scanning Cepat Kamera & USB',
                                'Peringatan Otomatis Stok Menipis',
                                'Transfer Barang & Penyesuaian Antarcabang',
                                'Program Loyalty & Poin Member Pelanggan',
                            ],
                        ],
                        [
                            'id' => 'jasa',
                            'label' => 'Penyedia Jasa & Salon',
                            'title' => 'Kenyamanan Layanan dan Pelanggan Prioritas',
                            'description' => 'Atur jadwal booking terapis atau staf tanpa bentrok, hitung bagi hasil komisi otomatis, dan simpan riwayat kunjungan klien.',
                            'image_url' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'features' => [
                                'Penjadwalan Reservasi & Kalender Janji Temu',
                                'Kalkulasi Komisi Staf & Terapis Otomatis',
                                'Riwayat Perawatan & Preferensi Pelanggan',
                                'Pengingat Janji Temu Otomatis via WhatsApp',
                            ],
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'pricing_plans',
                'order' => 5,
                'title' => 'Pilih Paket Sesuai Skala Bisnis Anda',
                'subtitle' => 'Investasi transparan tanpa biaya tersembunyi. Mulai dari satu gerai dan tingkatkan fitur seiring pertumbuhan bisnis Anda.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Paket & Harga',
                    'plans' => [
                        [
                            'name' => 'Basic',
                            'price' => 'Rp 149.000',
                            'period' => '/bulan',
                            'badge' => 'Pemula',
                            'description' => 'Pilihan tepat untuk gerai baru atau usaha tunggal yang ingin mulai beralih ke kasir digital.',
                            'is_popular' => false,
                            'button_text' => 'Pilih Paket Basic',
                            'features' => [
                                '1 Outlet & 2 Akun Kasir',
                                'Transaksi Penjualan Tanpa Batas',
                                'Manajemen Stok Produk Dasar',
                                'Cetak Struk Thermal & Struk Digital',
                                'Laporan Penjualan Harian',
                                'Dukungan Teknis via Email',
                            ],
                        ],
                        [
                            'name' => 'Profesional',
                            'price' => 'Rp 299.000',
                            'period' => '/bulan',
                            'badge' => 'Paling Populer',
                            'description' => 'Paket terlengkap untuk restoran dan toko yang aktif bertumbuh dengan kebutuhan manajemen tingkat lanjut.',
                            'is_popular' => true,
                            'button_text' => 'Mulai Paket Profesional',
                            'features' => [
                                'Hingga 3 Outlet & Kasir Tak Terbatas',
                                'Manajemen Resep Bahan & Kalkulasi HPP',
                                'Multi Cabang & Transfer Stok Antargudang',
                                'Integrasi Pembayaran QRIS Dinamis',
                                'Sistem Komisi Karyawan & Otorisasi Lengkap',
                                'Laporan Analitik & Tren Penjualan Lengkap',
                                'Dukungan Prioritas WhatsApp 24/7',
                            ],
                        ],
                        [
                            'name' => 'Enterprise',
                            'price' => 'Hubungi Kami',
                            'period' => '',
                            'badge' => 'Skala Korporat',
                            'description' => 'Solusi khusus untuk jaringan waralaba dan bisnis skala besar yang membutuhkan integrasi sistem kustom.',
                            'is_popular' => false,
                            'button_text' => 'Hubungi Tim Sales',
                            'features' => [
                                'Outlet & Terminal Kasir Tak Terbatas',
                                'Integrasi API ERP & Sistem Akuntansi Kustom',
                                'Dedicated Cloud Server & Custom Domain',
                                'SLA Jaminan Uptime 99.99%',
                                'Pelatihan On-Site & Dedicated Account Manager',
                                'Kustomisasi Fitur Sesuai Kebutuhan',
                            ],
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'testimonials',
                'order' => 6,
                'title' => 'Apa Kata Pemilik Usaha Tentang Sollu POS',
                'subtitle' => 'Lebih dari 10.000 mitra bisnis telah mempercayakan sistem operasional kasir harian mereka kepada kami.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Cerita Pelanggan',
                    'reviews' => [
                        [
                            'quote' => 'Sejak beralih ke Sollu POS, antrean kasir di 4 cabang kafe kami terpangkas drastis. Fitur resep bahan bakunya sangat akurat menjaga food cost tetap aman dari selisih.',
                            'name' => 'Rian Hidayat',
                            'role' => 'Pemilik & Pengelola',
                            'business' => 'Kopi Titik Temu (4 Cabang)',
                            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                        ],
                        [
                            'quote' => 'Barcode scanning-nya super kilat, stok ribuan produk fashion kami selalu sinkron antarcabang. Laporan penjualan malam hari selesai dalam 1 menit.',
                            'name' => 'Siti Maulida',
                            'role' => 'Founder',
                            'business' => 'Aura Modest Store',
                            'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'contact_cta',
                'order' => 7,
                'title' => 'Siap Mengembangkan Usaha Anda Bersama Sollu?',
                'subtitle' => 'Mulai uji coba gratis 14 hari tanpa kartu kredit, atau diskusikan kebutuhan usaha Anda bersama spesialis kami.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Konsultasi & Kontak',
                    'cta_trial_text' => 'Coba Gratis 14 Hari',
                    'cta_whatsapp_text' => 'Konsultasi WhatsApp Sekarang',
                ],
                'is_active' => true,
            ],

            // ==========================================
            // 2. BLOG & TIPS USAHA
            // ==========================================
            [
                'page_slug' => 'blog',
                'section_key' => 'hero',
                'order' => 1,
                'title' => 'Wawasan & Panduan Mengembangkan Usaha',
                'subtitle' => 'Kumpulan strategi praktis, tren industri, dan tips manajemen bisnis untuk mendorong pertumbuhan usaha Anda ke level berikutnya.',
                'content' => null,
                'attributes' => [
                    'eyebrow' => 'Tips & Edukasi Bisnis',
                ],
                'is_active' => true,
            ],
        ];

        // Clean up legacy multipage records
        PageContent::whereIn('page_slug', ['services', 'pricing', 'contact'])->delete();
        PageContent::where('page_slug', 'home')->where('section_key', 'features')->delete();

        foreach ($contents as $content) {
            PageContent::updateOrCreate(
                [
                    'page_slug' => $content['page_slug'],
                    'section_key' => $content['section_key'],
                ],
                $content
            );
        }
    }
}
