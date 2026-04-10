<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SeoController extends Controller
{
    public function index()
    {
        $seoSettings = SeoSetting::orderBy('id')->get();

        return Inertia::render('Admin/Seo/Index', [
            'seoSettings' => $seoSettings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.id' => 'required|exists:seo_settings,id',
            'settings.*.meta_title' => 'required|string|max:255',
            'settings.*.meta_description' => 'nullable|string|max:500',
            'settings.*.og_image_url' => 'nullable|string|max:500',
        ]);

        foreach ($validated['settings'] as $item) {
            SeoSetting::where('id', $item['id'])->update([
                'meta_title' => $item['meta_title'],
                'meta_description' => $item['meta_description'] ?? null,
                'og_image_url' => $item['og_image_url'] ?? null,
            ]);
        }

        return redirect()->route('admin.seo.index')->with('success', 'Pengaturan SEO berhasil diperbarui.');
    }
}
