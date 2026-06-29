<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambahkan baris ini
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Vite::prefetch(concurrency: 3);

        Gate::define('manage-users', function (User $user) {
            return $user->isSuperAdmin();
        });

        Gate::define('manage-settings', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        Gate::define('manage-pages', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        Gate::define('manage-seo', function (User $user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        \Illuminate\Support\Facades\Log::listen(function (\Illuminate\Log\Events\MessageLogged $message) {
            if (in_array($message->level, ['error', 'critical', 'alert', 'emergency'])) {
                $webhookUrl = env('DISCORD_WEBHOOK_URL');
                if ($webhookUrl) {
                    $text = "⚠️ **" . strtoupper($message->level) . ":** " . $message->message;
                    if (!empty($message->context['exception']) && $message->context['exception'] instanceof \Throwable) {
                        $e = $message->context['exception'];
                        $text .= "\n**File:** `" . $e->getFile() . ":" . $e->getLine() . "`";
                    }

                    // Tambahan informasi untuk mempermudah reproduce error
                    if (!app()->runningInConsole()) {
                        $request = request();
                        $text .= "\n\n**📌 How to Reproduce:**";
                        $text .= "\n- **URL:** `{$request->method()} {$request->fullUrl()}`";
                        
                        $user = $request->user();
                        $text .= "\n- **User:** " . ($user ? "`ID: {$user->id}`" : "`Guest`");
                        
                        $input = $request->except(['password', 'password_confirmation', 'token', 'pin']);
                        if (!empty($input)) {
                            $text .= "\n- **Payload:**\n```json\n" . json_encode($input, JSON_PRETTY_PRINT) . "\n```";
                        }
                    } else {
                        $text .= "\n\n**📌 Context:** `Console Command / Queue Worker`";
                    }

                    try {
                        \Illuminate\Support\Facades\Http::timeout(3)->post($webhookUrl, [
                            'content' => $text,
                        ]);
                    } catch (\Throwable $t) {
                        // Abaikan kegagalan webhook
                    }
                }
            }
        });
    }
}
