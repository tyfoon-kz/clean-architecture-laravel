<?php

namespace App\Support\Metrics;

class MetricsStore
{
    private const HISTOGRAM_BUCKETS = [0.05, 0.1, 0.25, 0.5, 1, 2.5, 5];

    public function incrementCounter(string $name, array $labels = [], int $amount = 1, ?string $help = null): void
    {
        $this->mutate(function (array $data) use ($name, $labels, $amount, $help) {
            $key = $this->seriesKey($name, $labels);
            $data['counters'][$key] ??= [
                'name' => $name,
                'help' => $help ?? "Counter {$name}.",
                'labels' => $labels,
                'value' => 0,
            ];
            $data['counters'][$key]['value'] += $amount;

            return $data;
        });
    }

    public function observeHistogram(string $name, float $value, array $labels = [], ?string $help = null, array $buckets = self::HISTOGRAM_BUCKETS): void
    {
        $this->mutate(function (array $data) use ($name, $value, $labels, $help, $buckets) {
            $key = $this->seriesKey($name, $labels);
            $data['histograms'][$key] ??= [
                'name' => $name,
                'help' => $help ?? "Histogram {$name}.",
                'labels' => $labels,
                'buckets' => array_fill_keys(array_map('strval', $buckets), 0),
                'sum' => 0,
                'count' => 0,
            ];

            foreach ($buckets as $bucket) {
                if ($value <= $bucket) {
                    $data['histograms'][$key]['buckets'][(string) $bucket]++;
                }
            }

            $data['histograms'][$key]['sum'] += $value;
            $data['histograms'][$key]['count']++;

            return $data;
        });
    }

    public function read(): array
    {
        $path = $this->path();

        if (! file_exists($path)) {
            return $this->emptyData();
        }

        $decoded = json_decode((string) file_get_contents($path), true);

        return is_array($decoded) ? array_replace_recursive($this->emptyData(), $decoded) : $this->emptyData();
    }

    private function mutate(callable $callback): void
    {
        $path = $this->path();
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $handle = fopen($path, 'c+');

        if ($handle === false) {
            return;
        }

        flock($handle, LOCK_EX);
        $contents = stream_get_contents($handle);
        $data = $contents ? json_decode($contents, true) : $this->emptyData();
        $data = is_array($data) ? array_replace_recursive($this->emptyData(), $data) : $this->emptyData();
        $data = $callback($data);

        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, json_encode($data, JSON_PRETTY_PRINT));
        fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);
    }

    private function seriesKey(string $name, array $labels): string
    {
        ksort($labels);

        return $name.'|'.json_encode($labels);
    }

    private function path(): string
    {
        return storage_path('app/metrics.json');
    }

    private function emptyData(): array
    {
        return [
            'counters' => [],
            'histograms' => [],
        ];
    }
}
