# Final observability map

## Documents

- `docs/metrics-baseline.md`
- `docs/observability-map.md`
- `docs/metrics-label-policy.md`
- `docs/metric-types.md`
- `docs/runtime-metrics.md`
- `docs/observability-dashboard.md`
- `docs/octane-metrics-validation.md`
- `docs/slo.md`
- `docs/alert-policy.md`
- `docs/runbooks/product-catalog-high-error-rate.md`
- `docs/runbooks/product-catalog-high-latency.md`

## Runtime artifacts

- `docker-compose.observability.yml`
- `monitoring/prometheus/prometheus.yml`
- `monitoring/prometheus/alerts/laravel.yml`
- `monitoring/grafana/provisioning/datasources/prometheus.yml`
- `monitoring/grafana/provisioning/dashboards/laravel.yml`
- `monitoring/grafana/dashboards/laravel-observability.json`

## Application artifacts

- `/metrics` endpoint;
- HTTP request metrics middleware;
- queue job metrics;
- worker/runtime gauges.

## Final check

```bash
make metrics-up
make metrics-demo
make metrics-check
make prometheus-targets
make grafana-open
```
