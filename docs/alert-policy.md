# Alert policy

Alerts exist to start action, not to decorate a dashboard.

## First alert rules

| Alert | Condition | First action |
| --- | --- | --- |
| `LaravelHighErrorRate` | 5xx error rate stays above 1% for 10 minutes | Check dashboard, recent deploys and logs. |
| `LaravelHighP95Latency` | p95 latency stays above 500ms for 10 minutes | Check request rate, database behavior, queue backlog and worker memory. |
| `LaravelQueueBacklogGrowing` | default queue backlog stays above 100 jobs for 15 minutes | Check queue workers, failed jobs and job duration. |

## Runbooks

- `LaravelHighErrorRate`: `docs/runbooks/product-catalog-high-error-rate.md`
- `LaravelHighP95Latency`: `docs/runbooks/product-catalog-high-latency.md`

## Noise rule

If an alert has no owner, no action and no runbook, it is not ready. A warning without action becomes background noise.
