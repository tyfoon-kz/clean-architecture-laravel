<?php

namespace App\Jobs;

use App\Models\Product;
use App\Support\Metrics\MetricsStore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecalculateProductSearchIndex implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $productId) {}

    public function handle(): void
    {
        $startedAt = microtime(true);
        $result = 'success';

        try {
            $product = Product::find($this->productId);

            if (! $product) {
                $result = 'missing_product';

                return;
            }

            $product->forceFill(['search_indexed_at' => now()])->save();

            Log::info('Product search index recalculated', [
                'product_id' => $product->id,
                'sku' => $product->sku,
            ]);
        } catch (Throwable $exception) {
            $result = 'failed';

            throw $exception;
        } finally {
            $this->recordMetrics($result, microtime(true) - $startedAt);
        }
    }

    private function recordMetrics(string $result, float $duration): void
    {
        $labels = [
            'queue' => $this->queue ?? 'default',
            'job' => class_basename(self::class),
            'result' => $result,
        ];

        $metrics = app(MetricsStore::class);
        $metrics->incrementCounter('laravel_queue_jobs_total', $labels, help: 'Total queue jobs handled by Laravel.');
        $metrics->observeHistogram('laravel_queue_job_duration_seconds', $duration, $labels, help: 'Queue job duration in seconds.');
    }
}
