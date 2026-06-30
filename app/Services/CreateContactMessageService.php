<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;

class CreateContactMessageService
{
    public function execute(array $data): ContactMessage
    {
        $message = ContactMessage::create($data);

        $this->notifyDiscord($message);

        return $message;
    }

    private function notifyDiscord(ContactMessage $message): void
    {
        $webhookUrl = env('DISCORD_INQUIRY_WEBHOOK_URL');
        if (!$webhookUrl) {
            return;
        }

        $detailUrl = route('admin.messages.show', $message->id);

        $content = "📩 **Pesan Masuk Baru!**\n";
        $content .= "**Email:** " . ($message->email ?? 'Tidak disertakan') . "\n";
        $content .= "**Pesan:**\n> " . str_replace("\n", "\n> ", $message->message) . "\n\n";
        $content .= "🔗 **Link Admin:** {$detailUrl}";

        try {
            Http::timeout(3)->post($webhookUrl, [
                'content' => $content,
            ]);
        } catch (\Throwable $e) {
            // Abaikan error webhook agar pengiriman pesan tidak terganggu
        }
    }
}
