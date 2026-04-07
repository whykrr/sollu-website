<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\PageContent;

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
}
