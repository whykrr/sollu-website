<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index()
    {
        $friendlyNames = [
            'home' => 'Landing Page Utama',
            'blog' => 'Tips Usaha & Blog',
        ];

        $friendlyDescriptions = [
            'home' => 'Kelola seluruh bagian Landing Page (Hero, Keunggulan & Metrik, Fitur Unggulan, Solusi Industri, Paket Harga, Testimoni, dan Kontak).',
            'blog' => 'Kelola banner dan headline untuk halaman Tips & Edukasi Usaha.',
        ];

        $pages = PageContent::select('page_slug')
            ->groupBy('page_slug')
            ->orderByRaw('MIN(id)')
            ->get()
            ->pluck('page_slug')
            ->map(function ($slug) use ($friendlyNames, $friendlyDescriptions) {
                return [
                    'slug' => $slug,
                    'name' => $friendlyNames[$slug] ?? ucfirst($slug),
                    'description' => $friendlyDescriptions[$slug] ?? 'Kelola teks dan visual untuk halaman '.ucfirst($slug).'.',
                ];
            });

        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages,
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
            'pageContents' => $contents,
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:512',
        ]);

        $path = $request->file('image')->store('uploads');

        return response()->json([
            'url' => Storage::disk('s3')->url($path),
        ]);
    }
}
