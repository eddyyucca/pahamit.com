<?php

namespace App\Http\Middleware;

use App\Models\SiteVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackSiteVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request, $response)) {
            $visitDate = now()->toDateString();
            $path = '/' . ltrim($request->path(), '/');
            $ipHash = hash('sha256', (string) $request->ip());

            $alreadyTracked = SiteVisit::query()
                ->whereDate('visit_date', $visitDate)
                ->where('path', $path)
                ->where('ip_hash', $ipHash)
                ->exists();

            if (! $alreadyTracked) {
                SiteVisit::create([
                    'visit_date' => $visitDate,
                    'path' => $path,
                    'ip_hash' => $ipHash,
                    'user_agent' => substr((string) $request->userAgent(), 0, 500),
                ]);
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if (! $request->isMethod('get') || ! Schema::hasTable('site_visits')) {
            return false;
        }

        if ($response->getStatusCode() >= 400 || $request->expectsJson()) {
            return false;
        }

        $userAgent = strtolower((string) $request->userAgent());

        if ($userAgent === '' || preg_match('/bot|crawl|spider|slurp|preview|monitor|uptime/', $userAgent)) {
            return false;
        }

        return true;
    }
}
