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
        $sitemaps = [];
        $files = File::glob(public_path('sitemap*.xml'));

        foreach ($files as $file) {
            $sitemaps[] = [
                'name' => basename($file),
                'size' => $this->formatBytes(File::size($file)),
                'last_modified' => date('Y-m-d H:i:s', File::lastModified($file)),
                'url' => url('/' . basename($file)),
            ];
        }

        return Inertia::render('Admin/Sitemap/Index', [
            'sitemaps' => $sitemaps,
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
                ->with('success', 'Sitemap berhasil digenerate dan didaftarkan ke robots.txt.');
        } catch (\Exception $e) {
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
