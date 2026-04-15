<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\SeoSetting;
use App\Models\Article;
use Symfony\Component\HttpFoundation\Response;

class ShareOpenGraphData
{
    /**
     * Map route names to their corresponding SEO page slugs.
     */
    private const ROUTE_SEO_MAP = [
        'home' => 'home',
        'services' => 'services',
        'pricing' => 'pricing',
        'contact' => 'contact',
        'blog' => 'blog',
    ];

    /**
     * Handle an incoming request.
     *
     * Resolves Open Graph data from the database based on the current route
     * and shares it with the Blade root template so crawlers can read OG tags
     * without executing JavaScript.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ogData = $this->resolveOpenGraphData($request);

        View::share('og', $ogData);

        return $next($request);
    }

    /**
     * Resolve OG data based on the current route.
     */
    private function resolveOpenGraphData(Request $request): array
    {
        $routeName = $request->route()?->getName();
        $currentUrl = $request->url();
        $siteName = config('app.name', 'Sollu POS');

        // Default OG data
        $ogData = [
            'title' => $siteName,
            'description' => null,
            'image' => null,
            'url' => $currentUrl,
            'type' => 'website',
            'site_name' => $siteName,
        ];

        // Blog article detail page
        if ($routeName === 'blog.show') {
            return $this->resolveArticleOg($request, $ogData);
        }

        // Static pages with SEO settings
        if ($routeName && isset(self::ROUTE_SEO_MAP[$routeName])) {
            return $this->resolvePageOg(self::ROUTE_SEO_MAP[$routeName], $ogData);
        }

        return $ogData;
    }

    /**
     * Resolve OG data for a static page from seo_settings table.
     */
    private function resolvePageOg(string $pageSlug, array $ogData): array
    {
        $seo = SeoSetting::where('page_slug', $pageSlug)->first();

        if ($seo) {
            $ogData['title'] = $seo->meta_title ?: $ogData['title'];
            $ogData['description'] = $seo->meta_description;
            $ogData['image'] = $seo->og_image_url;
        }

        return $ogData;
    }

    /**
     * Resolve OG data for a blog article detail page.
     */
    private function resolveArticleOg(Request $request, array $ogData): array
    {
        $slug = $request->route('slug');

        $article = Article::published()
            ->where('slug', $slug)
            ->first(['title', 'excerpt', 'image_url', 'slug']);

        if ($article) {
            $ogData['title'] = $article->title . ' — ' . $ogData['site_name'];
            $ogData['description'] = $article->excerpt;
            $ogData['image'] = $article->image_url;
            $ogData['type'] = 'article';
        }

        return $ogData;
    }
}
