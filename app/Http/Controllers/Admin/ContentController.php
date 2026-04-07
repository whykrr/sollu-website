<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index()
    {
        $pages = PageContent::select('page_slug')
            ->distinct()
            ->get()
            ->pluck('page_slug')
            ->map(function ($slug) {
                return [
                    'slug' => $slug,
                    'name' => ucfirst($slug)
                ];
            });

        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages
        ]);
    }

    public function edit($slug)
    {
        $contents = PageContent::where('page_slug', $slug)
            ->orderBy('order')
            ->get();

        if ($contents->isEmpty()) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return Inertia::render('Admin/Pages/Edit', [
            'slug' => $slug,
            'name' => ucfirst($slug),
            'pageContents' => $contents
        ]);
    }

    public function update(Request $request, $slug)
    {
        $validated = $request->validate([
            'contents' => 'required|array',
            'contents.*.id' => 'required|exists:page_contents,id',
            'contents.*.title' => 'nullable|string',
            'contents.*.subtitle' => 'nullable|string',
            'contents.*.content' => 'nullable|string',
            'contents.*.attributes' => 'nullable|array',
        ]);

        foreach ($validated['contents'] as $item) {
            $content = PageContent::where('page_slug', $slug)
                                  ->where('id', $item['id'])
                                  ->first();
            
            if ($content) {
                $content->update([
                    'title' => $item['title'] ?? null,
                    'subtitle' => $item['subtitle'] ?? null,
                    'content' => $item['content'] ?? null,
                    'attributes' => $item['attributes'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.pages.index')->with('success', 'Konten halaman berhasil diperbarui.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);

        $path = $request->file('image')->store('uploads', 'public');
        
        return response()->json([
            'url' => '/storage/' . $path
        ]);
    }
}
