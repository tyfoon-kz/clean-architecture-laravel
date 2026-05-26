# Persistent Connections And Stale Behavior

In a long-running runtime, the process can reuse application objects and external connections longer than a single request.
This does not automatically mean that the application has a full connection pool like a Go service or a dedicated database proxy.
It means the lifecycle boundary changed and stale resources must be considered.

Suggested checks:

```bash
curl http://127.0.0.1:8000/dev/runtime/db-ping
docker compose ps
make octane-logs
```

If the database disappears and comes back, record the first request after the failure and the next request after that.
The interesting part is the reconnect boundary, not just whether a green response eventually returns.
