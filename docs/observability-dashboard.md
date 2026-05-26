# Observability dashboard

The Grafana dashboard is stored in `monitoring/grafana/dashboards/laravel-observability.json`.

## First panels

| Panel | Question |
| --- | --- |
| HTTP request rate | Is traffic flowing and which routes are active? |
| HTTP error rate | Did the backend start returning `5xx` responses? |
| HTTP p95 latency | Are most users still getting acceptable response time? |
| HTTP p99 latency | Is the slow tail hiding behind normal average latency? |

## Local workflow

```bash
make metrics-up
make grafana-open
```

Grafana uses provisioned Prometheus datasource from `monitoring/grafana/provisioning/datasources/prometheus.yml`, so the dashboard does not depend on manual local clicks.

## Percentile queries

Latency panels use `histogram_quantile` over `laravel_http_request_duration_seconds_bucket`.

```promql
histogram_quantile(0.95, sum by (le, route) (rate(laravel_http_request_duration_seconds_bucket[5m])))
```

This query depends on histogram buckets. It cannot be built from a simple average duration gauge.
