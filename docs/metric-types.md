# Metric types used in this project

## Counter

Use Counter when the value only grows and resets only when the process or storage resets.

Project examples:

- total HTTP requests;
- total queue jobs handled;
- total failed jobs.

Do not use Counter for current queue size, current memory usage or request duration.

## Gauge

Use Gauge when the value can go up and down.

Project examples:

- current queue backlog;
- current PHP memory usage;
- current number of pending jobs.

Do not use Gauge for total request count.

## Histogram

Use Histogram when the project needs latency buckets and percentiles.

Project examples:

- HTTP request duration;
- job duration.

The project starts with simple buckets that are useful for backend request latency:

```text
0.05, 0.1, 0.25, 0.5, 1, 2.5, 5 seconds
```

Buckets can be changed later when the real latency profile becomes clear.

## Summary

Summary is not the default choice in this course. It can calculate quantiles on the client side, but Histogram is easier to aggregate across instances in Prometheus. For the first Laravel observability layer, use Histogram for request duration.
