# Runtime Signals

## Purpose

This document names the first runtime signals the project should make visible before a full metrics stack is added.

The next observability course can turn these signals into Prometheus metrics and Grafana dashboards. For now, the goal is to know what the project needs to observe.

## Signal Map

| Signal | Question | Current Source | Future Metric Candidate |
| --- | --- | --- | --- |
| HTTP latency | Are users waiting longer than expected? | access logs / manual benchmark scripts | request duration histogram |
| Error rate | Are requests failing more often? | Laravel logs / HTTP status codes | error counter by route/status |
| Throughput | How much traffic is the app serving? | web server logs | request counter |
| Queue failures | Are background jobs failing or retrying? | failed jobs table / logs | failed jobs counter |
| Worker memory | Is Octane memory growing over time? | Octane status/logs | worker memory gauge |
| Worker restarts | Are workers restarting too often? | container/runtime logs | restart counter |
| Readiness | Is the app ready to serve real requests? | `/health/ready` | readiness gauge |

## Current Boundary

Logs and healthchecks are the current course scope.

Prometheus, Grafana, SLI/SLO and alert rules belong to the next course. This document prepares that bridge without pretending that a table in docs is already observability.
