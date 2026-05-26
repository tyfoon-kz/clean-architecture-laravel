# Observability dashboard

The Grafana dashboard is stored in `monitoring/grafana/dashboards/laravel-observability.json`.

## First panels

| Panel | Question |
| --- | --- |
| HTTP request rate | Is traffic flowing and which routes are active? |
| HTTP error rate | Did the backend start returning `5xx` responses? |
| HTTP p95 latency | Are most users still getting acceptable response time? |
| HTTP p99 latency | Is the slow tail hiding behind normal average latency? |

## Reading order

The dashboard is arranged as an operational story:

1. Check request rate to understand whether traffic changed.
2. Check error rate to see whether the backend is failing requests.
3. Check p95 latency to see whether normal user-facing latency is still acceptable.
4. Check p99 latency to see whether a small but painful tail exists.
5. Check queue and worker panels when they are added to understand whether the bottleneck moved outside the HTTP request.

This order avoids the common mistake of staring at one graph and inventing a cause too early.

## Panel rule

Every panel must answer one question. If a panel cannot be tied to a question, it should not be on the first backend dashboard.

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
