<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     * Records visitor data for public pages only.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests to public pages (not admin, not API, not assets, not health checks/bots)
        if (
            $request->isMethod('GET') &&
            ! $request->is('admin/*') &&
            ! $request->is('admin') &&
            ! $request->is('login') &&
            ! $request->is('register') &&
            ! $request->is('build/*') &&
            ! $request->is('storage/*') &&
            ! $request->is('up') &&
            ! $request->ajax() &&
            ! $request->wantsJson() &&
            $request->ip() !== '127.0.0.1' &&
            ! str_contains(strtolower($request->userAgent() ?? ''), 'curl')
        ) {
            try {
                Visitor::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => session()->getId(),
                    'url' => $request->path(),
                ]);
            } catch (\Exception $e) {
                // Silently fail — visitor tracking should never break user experience
                report($e);
            }
        }

        return $response;
    }
}
