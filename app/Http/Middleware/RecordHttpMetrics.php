<?php

namespace App\Http\Middleware;

use App\Support\Metrics\MetricsStore;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RecordHttpMetrics
{
    public function __construct(private readonly MetricsStore $metrics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $startedAt = microtime(true);
        $status = 500;

        try {
            $response = $next($request);
            $status = $response->getStatusCode();

            return $response;
        } catch (Throwable $exception) {
            throw $exception;
        } finally {
            if (! $this->shouldSkip($request)) {
                $this->record($request, $status, microtime(true) - $startedAt);
            }
        }
    }

    private function shouldSkip(Request $request): bool
    {
        return $request->is('metrics') || $request->is('up');
    }

    private function record(Request $request, int $status, float $duration): void
    {
        $labels = [
            'method' => $request->method(),
            'route' => $this->routeLabel($request),
            'status' => (string) $status,
        ];

        $this->metrics->incrementCounter(
            'laravel_http_requests_total',
            $labels,
            help: 'Total HTTP requests handled by Laravel.',
        );

        $this->metrics->observeHistogram(
            'laravel_http_request_duration_seconds',
            $duration,
            $labels,
            help: 'HTTP request duration in seconds.',
        );
    }

    private function routeLabel(Request $request): string
    {
        $route = $request->route();

        if (! $route) {
            return 'unknown';
        }

        if ($route->getName()) {
            return $route->getName();
        }

        return $route->uri();
    }
}
