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

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $articleLabels[] = $month->translatedFormat('M Y');

            $count = Article::whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->count();
            $articleGrowth[] = $count;
        }

        // 3. Data RIIL Trafik Kunjungan dari tabel visitors (14 Hari Terakhir)
        $trafficLabels = [];
        $trafficPageViews = [];
        $trafficUniqueVisitors = [];

        for ($i = 13; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trafficLabels[] = $date->translatedFormat('d M');

            $trafficPageViews[] = Visitor::whereDate('created_at', $date->toDateString())->count();

            $trafficUniqueVisitors[] = Visitor::whereDate('created_at', $date->toDateString())
                                              ->distinct('session_id')
                                              ->count('session_id');
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
