# Memory Leak Diagnostics

The memory leak endpoint intentionally retains payloads in a static array.
It is a safe artificial demo, not an application feature.

```bash
make memory-leak-demo
make octane-status
```

Useful readings:

- `items_retained` shows whether the demo keeps references.
- `memory_usage_bytes` shows current allocated memory for the PHP process.
- `memory_peak_bytes` shows the highest observed memory usage.
- Octane logs and container status show whether workers are being restarted.

Warm-up memory growth is not automatically a leak.
A leak is suspicious when memory keeps growing with repeated similar requests and does not stabilize.
