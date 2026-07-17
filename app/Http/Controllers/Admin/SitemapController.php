<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GenerateSitemapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class SitemapController extends Controller
{
    /**
     * Display the sitemap generator page.
     */
    public function index()
    {
        $sitemapPath = public_path('sitemap.xml');
        $sitemap = null;

        if (File::exists($sitemapPath)) {
            $sitemap = [
                'name' => 'sitemap.xml',
                'size' => $this->formatBytes(File::size($sitemapPath)),
                'last_modified' => date('Y-m-d H:i:s', File::lastModified($sitemapPath)),
                'url' => url('/sitemap.xml'),
            ];
        }

        return Inertia::render('Admin/Sitemap/Index', [
            'sitemap' => $sitemap,
        ]);
    }

    /**
     * Generate a new sitemap.
     */
    public function generate(Request $request, GenerateSitemapService $service)
    {
        try {
            $service->execute();
            
            return redirect()->route('admin.sitemap.index')
                ->with('success', 'Sitemap berhasil digenerate.');
        } catch (\Exception $e) {
            // Since rules say log only for error/integration failure etc, this is a valid case.
            \Illuminate\Support\Facades\Log::error('Sitemap generation failed: ' . $e->getMessage());
            
            return redirect()->route('admin.sitemap.index')
                ->with('error', 'Gagal membuat sitemap. Silakan cek log untuk detail.');
        }
    }

    /**
     * Helper to format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
