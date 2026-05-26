# Runbook: product catalog high error rate

## Signal

Alert: `LaravelHighErrorRate`

The alert means the share of `5xx` responses stayed above the current SLO threshold long enough to require investigation.

## First checks

1. Open the Laravel Backend Observability dashboard.
2. Check whether the error rate is isolated to product catalog routes or affects all routes.
3. Check whether a deploy, migration or Octane reload happened before the error rate grew.
4. Open application logs and search for exceptions around the alert window.
5. Check database readiness and queue backlog.
6. Check whether `/metrics` itself is healthy, so the alert is not based on stale data.

## Local commands

```bash
make metrics-check
make health
make octane-status
make deploy-smoke
```

## Escalation

If the error rate started right after a recent code change, prepare rollback or revert. If errors are tied to database readiness, investigate connection and migration state before changing application code.
