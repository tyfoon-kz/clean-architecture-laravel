# Runbook: product catalog high latency

## Signal

Alert: `LaravelHighP95Latency`

The alert means p95 HTTP latency stayed above the current SLO threshold long enough to require investigation.

## First checks

1. Open the Laravel Backend Observability dashboard.
2. Check whether request rate changed before latency grew.
3. Check whether `5xx` error rate changed at the same time.
4. Check queue backlog and failed jobs.
5. Check worker memory and uptime.
6. Check recent deploy or Octane reload activity.

## Local commands

```bash
make metrics-check
make health
make octane-status
make deploy-smoke
```

## Escalation

If latency and errors grew after a recent change, prepare rollback or revert. If latency grew without errors, continue with database, queue and worker diagnostics before changing architecture.
