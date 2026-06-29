<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\ShareOpenGraphData::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            \App\Http\Middleware\TrackVisitor::class,
        ]);

        $middleware->trustProxies(at: '*'); // Percayai semua proxy
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Throwable $e, \Illuminate\Http\Request $request) {
            $statusCode = 500;
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                $statusCode = $e->getStatusCode();
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                $statusCode = $e->status;
            } elseif ($e instanceof \Illuminate\Auth\AuthenticationException) {
                $statusCode = 401;
            }

            if ($statusCode >= 400 && $statusCode < 600) {
                $webhookUrl = env('DISCORD_WEBHOOK_URL');
                if ($webhookUrl) {
                    $message = "⚠️ **HTTP {$statusCode}** on `{$request->fullUrl()}`";
                    if ($e->getMessage()) {
                        $message .= "\n**Message:** " . $e->getMessage();
                    }
                    if ($statusCode >= 500) {
                        $message .= "\n**File:** `" . $e->getFile() . ":" . $e->getLine() . "`";
                    }
                    
                    try {
                        \Illuminate\Support\Facades\Http::timeout(3)->post($webhookUrl, [
                            'content' => $message,
                        ]);
                    } catch (\Throwable $t) {
                        // Abaikan jika webhook gagal agar tidak mengganggu response aplikasi
                    }
                }
            }
        });
    })->create();
