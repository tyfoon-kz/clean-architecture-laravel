# Octane metrics validation

Octane is useful only when the project can describe its benefit and its cost.

## Before/after signals

Compare the classic baseline and Octane runtime with the same routes:

```bash
make benchmark-baseline
make octane-up
make benchmark-octane
make metrics-demo
make metrics-check
```

## What to compare

| Signal | Why |
| --- | --- |
| p95 latency | Shows user-facing tail behavior better than average. |
| p99 latency | Shows the slowest painful requests. |
| error rate | Faster runtime is not useful if failures grow. |
| worker memory | Long-running workers can accumulate state. |
| queue backlog | HTTP speed can hide delayed background work. |

## Decision note

If Octane improves latency but increases memory growth or operational complexity, document the tradeoff. If the data does not show a clear benefit, do not pretend the migration is proven.
