<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Store a new subscriber email from the coming soon page.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Check if already subscribed
        $existing = Subscriber::where('email', $validated['email'])->first();

        if ($existing) {
            return back()->with(
                'success',
                'Email Anda sudah terdaftar sebelumnya. Kami akan menghubungi Anda saat peluncuran!'
            );
        }

        Subscriber::create([
            'email' => $validated['email'],
            'subscribed_at' => now(),
        ]);

        return back()->with(
            'success',
            'Terima kasih! Anda akan menjadi yang pertama tahu saat kami meluncurkan.'
        );
    }
}
