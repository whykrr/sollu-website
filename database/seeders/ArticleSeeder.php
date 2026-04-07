<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all()->keyBy('slug');

        $articles = [
            [
                'category_slug' => 'bisnis-fb',
                'title' => 'Strategi Meningkatkan Penjualan F&B di Era Digital',
                'excerpt' => 'Pelajari bagaimana mengoptimalkan sistem POS Anda untuk meningkatkan retensi pelanggan dan mempercepat proses order di era serba digital.',
                'content' => '<h2>Mengapa Digitalisasi Penting untuk Bisnis F&B?</h2><p>Di era modern, pelanggan mengharapkan kecepatan dan kenyamanan. Sistem POS yang terintegrasi memungkinkan Anda memproses pesanan lebih cepat, mengurangi antrian, dan meningkatkan kepuasan pelanggan secara signifikan.</p><h3>1. Optimalkan Menu Digital</h3><p>Menu digital yang terintegrasi dengan sistem POS memungkinkan pembaruan harga dan item secara real-time. Pelanggan dapat melihat menu terbaru tanpa perlu mencetak ulang menu fisik.</p><h3>2. Analisis Data Penjualan</h3><p>Dengan data penjualan yang akurat, Anda dapat mengidentifikasi produk terlaris, jam sibuk, dan tren pembelian. Informasi ini sangat berharga untuk merencanakan strategi promosi dan pengelolaan stok bahan baku.</p><h3>3. Program Loyalitas Pelanggan</h3><p>Implementasikan program loyalitas digital yang terintegrasi langsung dengan sistem kasir. Pelanggan dapat mengumpulkan poin dan menukarkan reward tanpa kartu fisik.</p><blockquote><p>Bisnis F&B yang mengadopsi sistem POS modern mengalami peningkatan efisiensi operasional hingga 40% dalam 6 bulan pertama.</p></blockquote><p>Dengan menggabungkan teknologi POS modern dan strategi pemasaran digital, bisnis F&B Anda dapat berkompetisi lebih efektif di pasar yang semakin ketat.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(2),
            ],
            [
                'category_slug' => 'tips-retail',
                'title' => '5 Fitur Aplikasi Kasir yang Wajib Dimiliki Toko Retail Anda',
                'excerpt' => 'Jangan salah pilih aplikasi kasir. Pastikan kelima fitur ini tersedia agar toko Anda beroperasi dengan maksimal dan efisien.',
                'content' => '<h2>Memilih Aplikasi Kasir yang Tepat</h2><p>Aplikasi kasir bukan sekadar alat untuk mencatat transaksi. Di era modern, aplikasi kasir harus menjadi pusat kendali operasional bisnis retail Anda.</p><h3>1. Manajemen Inventori Real-Time</h3><p>Fitur ini memungkinkan Anda melacak stok barang secara akurat dan otomatis. Setiap kali terjadi penjualan, stok akan berkurang secara otomatis, sehingga Anda selalu mengetahui kondisi inventori terkini.</p><h3>2. Barcode Scanner Terintegrasi</h3><p>Pemindaian barcode mempercepat proses checkout dan mengurangi kesalahan input manual. Fitur ini juga mempermudah proses penerimaan barang dari supplier.</p><h3>3. Laporan Penjualan Komprehensif</h3><p>Laporan harian, mingguan, dan bulanan yang detail membantu Anda memahami performa bisnis. Grafik visual memudahkan analisis tren penjualan.</p><h3>4. Multi-Payment Gateway</h3><p>Dukung berbagai metode pembayaran: tunai, kartu debit/kredit, e-wallet, dan QRIS. Semakin banyak opsi pembayaran, semakin nyaman pelanggan bertransaksi.</p><h3>5. Manajemen Multi-Cabang</h3><p>Jika bisnis Anda memiliki lebih dari satu cabang, pastikan aplikasi kasir mendukung pengelolaan terpusat dari satu dashboard.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(5),
            ],
            [
                'category_slug' => 'keuangan',
                'title' => 'Cara Menentukan Harga Jual yang Pas (Pricing Strategy)',
                'excerpt' => 'Menentukan HPP dan margin keuntungan yang tepat adalah kunci keberhasilan bisnis jangka panjang. Pelajari strateginya di sini.',
                'content' => '<h2>Dasar-Dasar Penetapan Harga</h2><p>Penetapan harga yang tepat adalah seni dan ilmu. Harga terlalu tinggi membuat pelanggan kabur, terlalu rendah menggerus margin keuntungan Anda.</p><h3>Metode Cost-Plus Pricing</h3><p>Metode paling umum: hitung HPP (Harga Pokok Penjualan) lalu tambahkan margin keuntungan yang diinginkan. Rumusnya sederhana:</p><p><strong>Harga Jual = HPP + (HPP × Persentase Margin)</strong></p><h3>Metode Value-Based Pricing</h3><p>Tetapkan harga berdasarkan nilai yang dirasakan pelanggan. Metode ini cocok untuk produk premium atau unik yang tidak memiliki kompetitor langsung.</p><h3>Competitive Pricing</h3><p>Analisis harga kompetitor dan posisikan harga Anda secara strategis. Anda bisa memilih untuk menjadi pemimpin harga terendah, mencocokkan harga pasar, atau menetapkan harga premium.</p><h3>Tips Praktis</h3><ul><li>Selalu hitung HPP secara akurat termasuk biaya tersembunyi</li><li>Review harga secara berkala (minimal setiap kuartal)</li><li>Uji coba harga baru pada segmen kecil sebelum diterapkan menyeluruh</li><li>Gunakan sistem POS untuk melacak margin per produk secara otomatis</li></ul>',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(8),
            ],
            [
                'category_slug' => 'layanan-jasa',
                'title' => 'Pentingnya Pembukuan Otomatis untuk Jasa Pangkas Rambut',
                'excerpt' => 'Sistem reservasi dan komisi tak pernah semudah ini sejak adopsi digitalisasi pada bisnis layanan jasa.',
                'content' => '<h2>Transformasi Digital Bisnis Barbershop</h2><p>Bisnis pangkas rambut modern tidak lagi sekadar soal skill memotong—ini tentang pengalaman pelanggan secara menyeluruh.</p><h3>Sistem Booking Online</h3><p>Dengan sistem booking terintegrasi, pelanggan dapat memilih barber favorit, melihat jadwal yang tersedia, dan melakukan reservasi kapan saja. Ini mengurangi waktu tunggu dan meningkatkan kepuasan pelanggan.</p><h3>Perhitungan Komisi Otomatis</h3><p>Setiap barber memiliki skema komisi yang berbeda. Dengan sistem POS yang tepat, perhitungan komisi dilakukan secara otomatis berdasarkan transaksi yang diselesaikan.</p><h3>Riwayat Pelanggan</h3><p>Simpan preferensi gaya rambut setiap pelanggan. Barber dapat memberikan layanan yang lebih personal dengan mengingat gaya potongan yang diinginkan pelanggan sebelumnya.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(12),
            ],
            [
                'category_slug' => 'bisnis-fb',
                'title' => 'Panduan Lengkap Kitchen Display System (KDS) untuk Restoran',
                'excerpt' => 'Kitchen Display System menggantikan kertas order tradisional. Pelajari cara implementasinya agar dapur restoran Anda lebih efisien.',
                'content' => '<h2>Apa itu Kitchen Display System?</h2><p>Kitchen Display System (KDS) adalah layar digital yang dipasang di dapur restoran untuk menampilkan pesanan pelanggan secara real-time. KDS menggantikan printer kertas tradisional dan mengurangi risiko pesanan hilang atau salah baca.</p><h3>Keuntungan Menggunakan KDS</h3><ul><li><strong>Akurasi Pesanan</strong> — Pesanan ditampilkan dengan jelas di layar, mengurangi kesalahan akibat tulisan tangan yang tidak terbaca.</li><li><strong>Efisiensi Waktu</strong> — Tim dapur dapat melihat urutan prioritas dan estimasi waktu penyajian.</li><li><strong>Paperless</strong> — Mengurangi biaya kertas dan membantu lingkungan.</li><li><strong>Tracking</strong> — Manajemen dapat melacak waktu rata-rata penyiapan setiap menu.</li></ul><h3>Cara Implementasi</h3><p>Pastikan KDS terintegrasi langsung dengan sistem POS di kasir. Setiap pesanan yang diinput kasir akan otomatis muncul di layar dapur dalam hitungan detik.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => now()->subDays(15),
            ],
            [
                'category_slug' => 'tips-retail',
                'title' => 'Mengapa Bisnis Retail Anda Butuh Sistem Multi-Cabang?',
                'excerpt' => 'Ekspansi bisnis retail memerlukan sistem terpusat. Artikel ini menjelaskan mengapa dan bagaimana mengelola multi-cabang secara efisien.',
                'content' => '<h2>Tantangan Bisnis Multi-Cabang</h2><p>Menjalankan satu toko saja sudah menantang. Bayangkan mengelola 3, 5, atau bahkan 10 cabang sekaligus tanpa sistem yang terintegrasi!</p><h3>Masalah Umum Tanpa Sistem Terpusat</h3><ul><li>Stok di cabang A habis sementara cabang B kelebihan</li><li>Laporan keuangan dari setiap cabang harus dikumpulkan manual</li><li>Harga produk tidak konsisten antar cabang</li><li>Kesulitan memantau performa karyawan di setiap lokasi</li></ul><h3>Solusi: Dashboard Terpusat</h3><p>Dengan sistem POS multi-cabang, Anda dapat memantau seluruh operasional dari satu layar. Transfer stok antar cabang, standardisasi harga, dan review laporan konsolidasi menjadi mudah.</p><p>Investasi pada sistem multi-cabang sejak awal akan menghemat waktu dan biaya operasional dalam jangka panjang.</p>',
                'image_url' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                'published_at' => null, // Draft — belum dipublikasikan
            ],
        ];

        foreach ($articles as $data) {
            $categorySlug = $data['category_slug'];
            unset($data['category_slug']);

            Article::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'user_id' => $user->id,
                    'category_id' => $categories[$categorySlug]->id ?? null,
                    'slug' => Str::slug($data['title']),
                ])
            );
        }
    }
}
