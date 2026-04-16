<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\User;
use App\Models\Visitor;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Matriks Utama (Stats)
        $todayVisitors = Visitor::whereDate('created_at', Carbon::today())->count();
        $uniqueVisitorsToday = Visitor::whereDate('created_at', Carbon::today())
                                      ->distinct('session_id')
                                      ->count('session_id');

        $stats = [
            'articles'        => Article::count(),
            'categories'      => Category::count(),
            'users'           => User::count(),
            'messages'        => ContactMessage::count(),
            'visitors_today'  => $todayVisitors,
            'unique_today'    => $uniqueVisitorsToday,
        ];

        // 2. Data Pertumbuhan Artikel (Asli dari Database untuk 6 bulan terakhir)
        $articleGrowth = [];
        $articleLabels = [];

        $sixMonthsAgo = Carbon::now()->startOfMonth()->subMonths(5);
        $articleCounts = Article::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count")
            ->where('created_at', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->pluck('count', 'month');

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $articleLabels[] = $month->translatedFormat('M Y');
            $monthKey = $month->format('Y-m');
            $articleGrowth[] = $articleCounts->get($monthKey, 0);
        }

        // 3. Data RIIL Trafik Kunjungan dari tabel visitors (14 Hari Terakhir)
        $trafficLabels = [];
        $trafficPageViews = [];
        $trafficUniqueVisitors = [];

        $fourteenDaysAgo = Carbon::now()->subDays(13)->startOfDay();
        $trafficStats = Visitor::selectRaw("DATE(created_at) as date, COUNT(*) as page_views, COUNT(DISTINCT session_id) as unique_visitors")
            ->where('created_at', '>=', $fourteenDaysAgo)
            ->groupBy('date')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trafficLabels[] = $date->translatedFormat('d M');
            $dateKey = $date->format('Y-m-d');

            $stat = $trafficStats->get($dateKey);
            $trafficPageViews[] = $stat ? $stat->page_views : 0;
            $trafficUniqueVisitors[] = $stat ? $stat->unique_visitors : 0;
        }

        // 4. Data Proporsi Artikel per Kategori (Asli)
        $categories = Category::withCount('articles')->get();
        $categoryLabels = $categories->pluck('name')->toArray();
        $categoryData = $categories->pluck('articles_count')->toArray();

        // 5. Halaman Paling Populer (Top 5 hari ini)
        $popularPages = Visitor::selectRaw('url, COUNT(*) as views')
                               ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                               ->groupBy('url')
                               ->orderByDesc('views')
                               ->limit(5)
                               ->get()
                               ->toArray();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'chartData' => [
                'articles' => [
                    'labels' => $articleLabels,
                    'data'   => $articleGrowth,
                ],
                'traffic' => [
                    'labels'     => $trafficLabels,
                    'pageViews'  => $trafficPageViews,
                    'unique'     => $trafficUniqueVisitors,
                ],
                'categories' => [
                    'labels' => $categoryLabels,
                    'data'   => $categoryData,
                ],
            ],
            'popularPages' => $popularPages,
        ]);
    }
}
