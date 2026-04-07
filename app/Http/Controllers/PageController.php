<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\PageContent;
use App\Models\Article;
use App\Models\Category;

class PageController extends Controller
{
    public function home()
    {
        $contents = PageContent::where('page_slug', 'home')->where('is_active', true)->get()->keyBy('section_key');
        return Inertia::render('Home/Index', ['pageContents' => $contents]);
    }

    public function services()
    {
        $contents = PageContent::where('page_slug', 'services')->where('is_active', true)->get()->keyBy('section_key');
        return Inertia::render('Services/Index', ['pageContents' => $contents]);
    }

    public function pricing()
    {
        $contents = PageContent::where('page_slug', 'pricing')->where('is_active', true)->get()->keyBy('section_key');
        return Inertia::render('Pricing/Index', ['pageContents' => $contents]);
    }

    public function contact()
    {
        $contents = PageContent::where('page_slug', 'contact')->where('is_active', true)->get()->keyBy('section_key');
        return Inertia::render('Contact/Index', ['pageContents' => $contents]);
    }

    public function blog(Request $request)
    {
        $query = Article::published()->with(['category', 'user'])->latest('published_at');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $articles = $query->paginate(9)->withQueryString();

        // Featured = artikel terbaru yang published
        $featuredArticle = Article::published()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->first();

        $categories = Category::withCount(['articles' => function ($q) {
            $q->published();
        }])->orderBy('name')->get();

        return Inertia::render('Blog/Index', [
            'articles' => $articles,
            'featuredArticle' => $featuredArticle,
            'categories' => $categories,
            'filters' => $request->only('category'),
        ]);
    }

    public function blogShow($slug)
    {
        $article = Article::published()
            ->with(['category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->with(['category'])
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return Inertia::render('Blog/Show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
