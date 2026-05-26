# Metrics label policy

Labels are useful only when they split a metric by stable engineering meaning. They become dangerous when they create a new time series for every user, product, request or free-form value.

## Allowed labels

These labels are safe for the first observability layer:

- `method`: HTTP method such as `GET` or `POST`.
- `route`: Laravel route name or route pattern, not a concrete URL with ids.
- `status`: HTTP status code grouped as the actual numeric code.
- `queue`: queue name.
- `job`: job class short name.
- `result`: small fixed set such as `success`, `failed`, `released`.
- `worker`: runtime role when the value is a small fixed set.

## Forbidden labels

Do not use these values as Prometheus labels:

- `user_id`
- `product_id`
- `email`
- `request_id`
- `session_id`
- raw search text
- full URL with ids or query string
- exception message

## Route rule

Use a route pattern or route name:

```text
route="api/products/{product}"
route="products.publish"
```

Do not use a concrete URL:

```text
route="/api/products/9821?debug=true"
```

The first form creates a bounded number of time series. The second form can create a new time series for every product and query value.

## Current project labels

| Metric area | Labels |
| --- | --- |
| HTTP requests | `method`, `route`, `status` |
| HTTP duration | `method`, `route`, `status` |
| Queue jobs | `queue`, `job`, `result` |
| Queue backlog | `queue` |
| Runtime memory | no dynamic labels |
