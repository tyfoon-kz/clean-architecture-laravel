# Metrics lifecycle through Redis, Prometheus and Grafana

The observability stack stores the training application metrics through a simple lifecycle:

```text
Laravel middleware/job
  -> App\Support\Metrics\MetricsStore
  -> Redis key metrics:prometheus
  -> Laravel /metrics endpoint
  -> Prometheus scrape over HTTP
  -> Prometheus time series database
  -> Grafana dashboard
```

Prometheus does not read Redis directly in this project. Laravel writes the current counters and histograms to Redis, then the `/metrics` endpoint reads that snapshot and renders Prometheus text format. Prometheus scrapes the HTTP endpoint, stores the samples as time series and Grafana queries Prometheus as a datasource.

The Redis-backed store is enabled by `docker-compose.observability.yml`:

```yaml
app:
  environment:
    METRICS_STORE: redis
    METRICS_REDIS_KEY: metrics:prometheus
    REDIS_CLIENT: predis
    REDIS_HOST: redis
    REDIS_PORT: 6379
```

Run the full local stack with:

```bash
make metrics-up
make metrics-demo
make metrics-check
make prometheus-targets
```

To inspect the Redis value directly:

```bash
make metrics-redis-cli
GET metrics:prometheus
```

This storage is intentionally simple for the course. A production-grade implementation would use atomic Redis operations or a dedicated metrics client/exporter to avoid lost updates under high concurrency.
