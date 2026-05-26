# Runtime metrics

The project exposes a small runtime snapshot through `/metrics`.

## Current runtime signals

- `laravel_worker_memory_bytes`
- `laravel_worker_memory_peak_bytes`
- `laravel_worker_uptime_seconds`
- `laravel_worker_process_id`
- `laravel_queue_backlog`
- `laravel_queue_failed_jobs`

These metrics are intentionally small. They do not replace deeper Octane diagnostics, but they make the first worker signals visible to Prometheus and Grafana.

## Octane note

In the classic FPM model, process lifetime is short and memory problems can disappear at the end of a request. In Octane/FrankenPHP, the worker can handle many requests, so uptime and memory growth are useful early signals.

## Local check

```bash
make metrics-check
```

Expected output contains worker and queue metric names.
