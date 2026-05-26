# Bottleneck Decision Notes

Octane can reduce repeated bootstrap cost and improve some warm-worker scenarios.
It does not automatically fix slow SQL, missing indexes, N+1 queries, external API latency, CPU-heavy code, lock contention or broken cache strategy.

When a route stays slow, write evidence before naming the cause:

- route and command used for measurement;
- HTTP status and rough latency;
- SQL count or slowest query if the route touches database;
- external service calls if any;
- CPU-heavy transformation if any;
- lock wait or transaction boundary if any;
- next optimization step and the layer it belongs to.
