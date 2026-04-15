<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when($request->status === 'unread', function ($query) {
                $query->where('is_read', false);
            })
            ->when($request->status === 'read', function ($query) {
                $query->where('is_read', true);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('business_name', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%")
                      ->orWhere('phone', 'ilike', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'read' => ContactMessage::where('is_read', true)->count(),
        ];

        return Inertia::render('Admin/Messages/Index', [
            'messages' => $messages,
            'filters' => $request->only('status', 'search'),
            'stats' => $stats,
        ]);
    }

    public function show(ContactMessage $message)
    {
        // Mark as read when viewed
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        // Load the repliedBy user relationship
        $message->load('repliedByUser');

        return Inertia::render('Admin/Messages/Show', [
            'message' => $message,
        ]);
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $validated = $request->validate([
            'reply_subject' => 'required|string|max:255',
            'reply_message' => 'required|string|max:10000',
        ]);

        // Require the contact to have an email
        if (!$message->email) {
            return redirect()->back()->with('error', 'Tidak dapat mengirim balasan: pengirim tidak mencantumkan email.');
        }

        $message->reply_subject = $validated['reply_subject'];

        // Send the email
        Mail::to($message->email)->send(
            new ContactReplyMail($message, $validated['reply_message'])
        );

        // Store the reply info
        $message->update([
            'reply_subject' => $validated['reply_subject'],
            'reply_message' => $validated['reply_message'],
            'replied_by' => $request->user()->id,
            'replied_at' => now(),
            'is_read' => true,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim ke ' . $message->email);
    }

    public function toggleRead(ContactMessage $message)
    {
        $message->update(['is_read' => !$message->is_read]);

        return redirect()->back()->with('success', $message->is_read
            ? 'Pesan ditandai sudah dibaca.'
            : 'Pesan ditandai belum dibaca.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}

