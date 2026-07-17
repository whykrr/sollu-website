<?php

namespace App\Services;

use App\Models\Article;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\File;

class GenerateSitemapService
{
    /**
     * Generate the sitemap for the application.
     *
     * @return void
     */
    public function execute(): void
    {
        // 1. Generate Sitemap for Core Pages
        $pagesSitemap = Sitemap::create();
        $pagesSitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $pagesSitemap->add(Url::create('/services')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $pagesSitemap->add(Url::create('/pricing')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $pagesSitemap->add(Url::create('/blog')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $pagesSitemap->add(Url::create('/faq')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $pagesSitemap->add(Url::create('/contact')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $pagesSitemap->writeToFile(public_path('sitemap-pages.xml'));

        // 2. Generate Sitemap for Articles
        $articlesSitemap = Sitemap::create();
        Article::published()->chunk(100, function ($articles) use ($articlesSitemap) {
            foreach ($articles as $article) {
                $articlesSitemap->add(
                    Url::create("/blog/{$article->slug}")
                        ->setLastModificationDate($article->updated_at)
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                );
            }
        });
        $articlesSitemap->writeToFile(public_path('sitemap-articles.xml'));

        // 3. Create Sitemap Index
        SitemapIndex::create()
            ->add('/sitemap-pages.xml')
            ->add('/sitemap-articles.xml')
            ->writeToFile(public_path('sitemap.xml'));

        // 4. Update robots.txt
        $this->updateRobotsTxt();
    }

    /**
     * Update robots.txt to include the sitemap index.
     */
    private function updateRobotsTxt(): void
    {
        $robotsPath = public_path('robots.txt');
        $sitemapUrl = url('/sitemap.xml');
        $sitemapDirective = "Sitemap: {$sitemapUrl}";

        if (File::exists($robotsPath)) {
            $content = File::get($robotsPath);
            // Check if Sitemap directive already exists
            if (preg_match('/^Sitemap:\s*.*$/m', $content)) {
                // Replace existing Sitemap directive
                $content = preg_replace('/^Sitemap:\s*.*$/m', $sitemapDirective, $content);
            } else {
                // Append if not found
                $content .= "\n\n" . $sitemapDirective;
            }
            File::put($robotsPath, trim($content) . "\n");
        } else {
            // Create default robots.txt if it doesn't exist
            $defaultContent = "User-agent: *\nDisallow: /admin/\nAllow: /\n\n" . $sitemapDirective . "\n";
            File::put($robotsPath, $defaultContent);
        }
    }
}
