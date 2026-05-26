# Observability map

This map connects backend questions to the signal type that can answer them. It is intentionally small at the start of the course and will grow with Prometheus, Grafana, SLO and alerts.

## Signal types

| Situation | Signal type | Why |
| --- | --- | --- |
| A user reports one failed request | Log | A log can show the concrete request context and exception. |
| The team wants to know whether latency changed after deploy | Metric | A metric can show numeric behavior over time. |
| A request crosses several services or expensive operations | Trace | A trace can show where time was spent in one path. |
| The business asks which category sells better | Analytics | Product analytics answer business behavior, not backend health. |

## RED model for HTTP

| Signal | Project example |
| --- | --- |
| Rate | Requests to product catalog routes per minute |
| Errors | `5xx` responses and unexpected `4xx` spikes |
| Duration | p95/p99 latency for catalog and publication routes |

## USE model for resources

| Signal | Project example |
| --- | --- |
| Utilization | Worker memory, database activity, queue worker usage |
| Saturation | Queue backlog, slow database responses, worker pressure |
| Errors | Failed jobs, failed readiness checks, rejected requests |

## First metric candidates

- `laravel_http_requests_total`
- `laravel_http_request_duration_seconds`
- `laravel_queue_jobs_total`
- `laravel_queue_backlog`
- `laravel_worker_memory_bytes`

## Label policy

The project label policy is stored in `docs/metrics-label-policy.md`. The most important rule is simple: labels may describe stable engineering groups, but they must not contain user ids, product ids, emails, request ids or raw URLs.

## Metric type decisions

Metric type notes are stored in `docs/metric-types.md`.

| Metric | Type | Reason |
| --- | --- | --- |
| `laravel_http_requests_total` | Counter | Requests only increase over time. |
| `laravel_http_request_duration_seconds` | Histogram | Latency needs buckets and percentiles. |
| `laravel_queue_jobs_total` | Counter | Handled jobs only increase over time. |
| `laravel_queue_backlog` | Gauge | Backlog can grow and shrink. |
| `laravel_worker_memory_bytes` | Gauge | Memory usage can grow and shrink. |

Runtime notes are stored in `docs/runtime-metrics.md`.
