<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\PageContent;
use App\Models\Faq;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate manual XML sitemap untuk SEO';

    public function handle()
    {
        // 1. Inisialisasi Sitemap
        $sitemap = Sitemap::create();

        // Helper function to get last modified date from PageContent
        $getLastMod = function ($slug) {
            $lastUpdate = PageContent::where('page_slug', $slug)->max('updated_at');
            return $lastUpdate ? Carbon::parse($lastUpdate) : now();
        };

        // 2. Tambahkan Halaman Statis
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setLastModificationDate($getLastMod('home')));

        $sitemap->add(Url::create('/pricing')
            ->setPriority(1.0)
            ->setLastModificationDate($getLastMod('pricing')));

        $sitemap->add(Url::create('/services')
            ->setPriority(0.8)
            ->setLastModificationDate($getLastMod('services')));

        // FAQ from Faq model
        $faqLastUpdate = Faq::max('updated_at');
        $faqLastMod = $faqLastUpdate ? Carbon::parse($faqLastUpdate) : $getLastMod('faq');

        $sitemap->add(Url::create('/faq')
            ->setPriority(0.6)
            ->setLastModificationDate($faqLastMod));

        // 3. Tambahkan Halaman Dinamis dari Database (Contoh: Postingan CMS)
        // Kita ambil data dari database via Eloquent
        Article::all()->each(function (Article $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.6)
            );
        });

        // 4. Simpan ke folder public
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap.xml berhasil diperbarui!');
    }
}
