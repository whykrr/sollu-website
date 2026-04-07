<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\PageContent;

class PageController extends Controller
{
    public function home()
    {
        $contents = PageContent::where('page_slug', 'home')
            ->where('is_active', true)
            ->get()
            ->keyBy('section_key');

        return Inertia::render('Home/Index', [
            'pageContents' => $contents
        ]);
    }
}
