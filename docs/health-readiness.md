# Health And Readiness

## Purpose

Healthchecks should answer more than "did the process start".

Laravel already exposes `/up` as a lightweight liveness endpoint. This project also adds `/health/ready` for a readiness check that touches important dependencies.

## Endpoints

```text
/up
/health/ready
```

`/up` is useful for a cheap liveness check.

`/health/ready` checks:

- database query;
- cache write/read path.

If a dependency check fails, the endpoint returns `503`.

## Make Target

```bash
make health
```

The target calls `/up` and `/health/ready` against `APP_URL` or `http://127.0.0.1:8000` by default.

## Boundary

This is not full observability. It is the first readiness signal. Logs, metrics, traces and incident investigation still matter.
