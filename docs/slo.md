# Service level objectives

This document defines the first internal service goals for the product catalog.

## SLI

| SLI | Query idea | Why |
| --- | --- | --- |
| Catalog availability | successful requests / total requests | Users need the catalog to answer. |
| Catalog error rate | `5xx` responses / total requests | Server errors are direct backend failures. |
| Catalog p95 latency | histogram p95 for catalog route | Slow catalog pages hurt daily work. |

## SLO

Initial internal objectives:

- Catalog availability should stay above 99% during the observation window.
- Catalog `5xx` error rate should stay below 1% during the observation window.
- Catalog p95 latency should stay below 500ms for normal local/demo load.

These numbers are training defaults. In a real company they would be negotiated with product and operations context.

## Notes

SLO is an internal engineering target. It is not the same as SLA. SLA is an external agreement with consequences outside the codebase.
