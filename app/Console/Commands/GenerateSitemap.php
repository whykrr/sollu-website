<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post; // Ganti dengan model CMS/Produk Anda

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate manual XML sitemap untuk SEO';

    public function handle()
    {
        // 1. Inisialisasi Sitemap
        $sitemap = Sitemap::create();

        // 2. Tambahkan Halaman Statis
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create('/service')
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        $sitemap->add(Url::create('/prices')
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        $sitemap->add(Url::create('/faq')
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        // 3. Tambahkan Halaman Dinamis dari Database (Contoh: Postingan CMS)
        // Kita ambil data dari Supabase via Eloquent
        Article::all()->each(function (Article $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        // 4. Simpan ke folder public
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap.xml berhasil diperbarui!');
    }
}
