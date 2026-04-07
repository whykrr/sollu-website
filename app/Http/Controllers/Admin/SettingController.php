<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string|exists:site_settings,key',
            'settings.*.value' => 'nullable|string',
        ]);

        foreach ($validated['settings'] as $item) {
            SiteSetting::where('key', $item['key'])->update(['value' => $item['value']]);
        }

        return redirect()->back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
