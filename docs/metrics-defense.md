# Metrics defense

## What changed

The project now has a minimal backend observability layer:

- Prometheus scrape configuration;
- Grafana datasource and dashboard provisioning;
- Laravel `/metrics` endpoint;
- HTTP request counter and duration histogram;
- queue job metrics;
- runtime worker gauges;
- label policy;
- SLI/SLO notes;
- alert policy and a latency runbook.

## Why these metrics

The first dashboard focuses on the RED model for HTTP:

- request rate;
- error rate;
- request duration.

The project also exposes queue and worker signals because this backend uses background jobs and Octane/FrankenPHP long-running workers. A green test suite cannot show queue backlog or memory growth over time.

## Cardinality decision

The project uses stable labels such as `method`, `route`, `status`, `queue`, `job` and `result`. It does not use `product_id`, `user_id`, email, request id or raw URL as labels.

## Histogram decision

HTTP duration is stored as a histogram because p95 and p99 latency are more useful than average latency for user-facing endpoints.

## Remaining risks

- The demo metrics store is intentionally simple and local to the training project.
- Real production would need persistent storage, auth/network rules and stronger deployment discipline.
- Alert thresholds are training defaults and must be adjusted with real traffic.
- More detailed tracing is outside this course.
