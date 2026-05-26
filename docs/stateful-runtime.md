# Stateful Runtime Notes

Static fields, globals and long-lived singletons become process memory under Octane.
The unsafe debug endpoint intentionally stores a marker in a static field so that the next request can see it.
The safe endpoint returns request-local data without retaining it for the next request.

```bash
curl -X POST http://127.0.0.1:8000/dev/runtime/static-leak/reset
curl http://127.0.0.1:8000/dev/runtime/static-leak/unsafe/first
curl http://127.0.0.1:8000/dev/runtime/static-leak/unsafe
curl http://127.0.0.1:8000/dev/runtime/static-leak/safe/first
curl http://127.0.0.1:8000/dev/runtime/static-leak/safe
```
