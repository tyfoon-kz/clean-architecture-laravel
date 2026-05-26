# Metrics baseline

This document is the starting point for the observability course. It records what the project can already prove through quality checks and what it still cannot measure in runtime.

## Project root

All commands in this course are expected to run from the project root.

```bash
pwd
make help
make qa
make health
```

## What is already checked

The project already has a local quality pipeline:

- `make check` validates versions, Composer metadata and the Laravel test suite.
- `make qa` combines style, static analysis, architecture tests, smoke checks, frontend build and diff checks.
- `make health` checks the existing liveness/readiness endpoints.
- `make benchmark-baseline` and `make benchmark-octane` can produce small runtime measurements.

These checks are useful, but they answer "can we safely change the code". They do not continuously answer "how does the running system behave".

## Runtime questions without metrics yet

- How many HTTP requests does the backend handle per minute?
- How many responses are `4xx` or `5xx`?
- What is p95 and p99 request latency for the product catalog?
- Is the queue processing jobs faster than the application creates them?
- Does Octane worker memory grow over time?
- Did the latest runtime change improve latency or just move the bottleneck somewhere else?

## First observability gaps

- There is no Prometheus scrape target yet.
- The application does not expose a `/metrics` endpoint yet.
- HTTP request duration is not collected as a histogram yet.
- Queue backlog and job duration are not exported yet.
- Octane worker signals are only checked through scripts and logs, not metrics.
- There is no Grafana dashboard tied to operational questions.

## Current rule

A green quality pipeline is necessary, but it is not the same as observable runtime behavior.

## Questions before adding tools

Before adding Prometheus, every runtime question should be phrased as a measurable signal.

| Question | Useful signal | Why it matters |
| --- | --- | --- |
| Are users seeing slow product pages? | HTTP request duration by route | A slow catalog route hurts real work even when tests pass. |
| Did the latest deploy increase failures? | HTTP responses by status code | Error rate is often visible before a bug report arrives. |
| Is background work falling behind? | Queue backlog and job duration | A healthy web request can still hide delayed processing. |
| Is Octane keeping too much state? | Worker memory and restarts | Long-running workers need runtime discipline from the previous course. |
| Did an optimization help? | Before/after latency and throughput | Architecture decisions need evidence, not confidence. |
