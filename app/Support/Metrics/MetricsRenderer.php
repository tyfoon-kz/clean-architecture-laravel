<?php

namespace App\Support\Metrics;

use Illuminate\Support\Facades\DB;
use Throwable;

class MetricsRenderer
{
    public function __construct(private readonly MetricsStore $store) {}

    public function render(): string
    {
        $lines = [];

        $this->appendGauge($lines, 'laravel_app_info', 'Laravel application info.', [
            'environment' => app()->environment(),
            'laravel_version' => app()->version(),
        ], 1);

        $this->appendGauge($lines, 'laravel_worker_memory_bytes', 'Current PHP memory usage in bytes.', [], memory_get_usage(true));
        $this->appendGauge($lines, 'laravel_worker_memory_peak_bytes', 'Peak PHP memory usage in bytes.', [], memory_get_peak_usage(true));
        $this->appendGauge($lines, 'laravel_queue_backlog', 'Current queued jobs waiting in the database queue.', [
            'queue' => 'default',
        ], $this->queueBacklog('default'));
        $this->appendGauge($lines, 'laravel_queue_failed_jobs', 'Current failed jobs stored by Laravel.', [
            'queue' => 'all',
        ], $this->failedJobs());

        $data = $this->store->read();

        foreach ($data['counters'] ?? [] as $counter) {
            $this->appendCounter(
                $lines,
                $counter['name'],
                $counter['help'] ?? "Counter {$counter['name']}.",
                $counter['labels'] ?? [],
                $counter['value'] ?? 0,
            );
        }

        foreach ($data['histograms'] ?? [] as $histogram) {
            $this->appendHistogram($lines, $histogram);
        }

        return implode("\n", $lines)."\n";
    }

    private function queueBacklog(string $queue): int
    {
        try {
            return DB::table('jobs')->where('queue', $queue)->count();
        } catch (Throwable) {
            return 0;
        }
    }

    private function failedJobs(): int
    {
        try {
            return DB::table('failed_jobs')->count();
        } catch (Throwable) {
            return 0;
        }
    }

    private function appendCounter(array &$lines, string $name, string $help, array $labels, int|float $value): void
    {
        $lines[] = "# HELP {$name} {$help}";
        $lines[] = "# TYPE {$name} counter";
        $lines[] = $name.$this->formatLabels($labels).' '.$this->formatValue($value);
    }

    private function appendGauge(array &$lines, string $name, string $help, array $labels, int|float $value): void
    {
        $lines[] = "# HELP {$name} {$help}";
        $lines[] = "# TYPE {$name} gauge";
        $lines[] = $name.$this->formatLabels($labels).' '.$this->formatValue($value);
    }

    private function appendHistogram(array &$lines, array $histogram): void
    {
        $name = $histogram['name'];
        $labels = $histogram['labels'] ?? [];
        $buckets = $histogram['buckets'] ?? [];

        $lines[] = "# HELP {$name} {$histogram['help']}";
        $lines[] = "# TYPE {$name} histogram";

        foreach ($buckets as $bucket => $count) {
            $bucketLabels = [...$labels, 'le' => (string) $bucket];
            $lines[] = "{$name}_bucket".$this->formatLabels($bucketLabels).' '.$this->formatValue($count);
        }

        $lines[] = "{$name}_bucket".$this->formatLabels([...$labels, 'le' => '+Inf']).' '.$this->formatValue($histogram['count'] ?? 0);
        $lines[] = "{$name}_sum".$this->formatLabels($labels).' '.$this->formatValue($histogram['sum'] ?? 0);
        $lines[] = "{$name}_count".$this->formatLabels($labels).' '.$this->formatValue($histogram['count'] ?? 0);
    }

    private function formatLabels(array $labels): string
    {
        if ($labels === []) {
            return '';
        }

        $formatted = collect($labels)
            ->map(fn (string|int|float $value, string $key) => $key.'="'.$this->escapeLabel((string) $value).'"')
            ->implode(',');

        return "{".$formatted."}";
    }

    private function escapeLabel(string $value): string
    {
        return str_replace(["\\", "\n", '"'], ["\\\\", "\\n", "\\\""], $value);
    }

    private function formatValue(int|float $value): string
    {
        return rtrim(rtrim(sprintf('%.6F', $value), '0'), '.');
    }
}
