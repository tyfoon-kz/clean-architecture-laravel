# Observability dashboard

The Grafana dashboard is stored in `monitoring/grafana/dashboards/laravel-observability.json`.

## First panels

| Panel | Question |
| --- | --- |
| HTTP request rate | Is traffic flowing and which routes are active? |
| HTTP error rate | Did the backend start returning `5xx` responses? |

## Local workflow

```bash
make metrics-up
make grafana-open
```

Grafana uses provisioned Prometheus datasource from `monitoring/grafana/provisioning/datasources/prometheus.yml`, so the dashboard does not depend on manual local clicks.
