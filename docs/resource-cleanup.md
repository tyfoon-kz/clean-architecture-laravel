# Resource Cleanup

Long-running workers make cleanup more visible.
If a request opens a stream, file, external SDK client or temporary resource and forgets to close it, the process can keep that resource longer than expected.

The demo endpoint uses `try/finally`.
That matters because cleanup must happen on both success and exception paths.

```bash
curl http://127.0.0.1:8000/dev/runtime/temporary-stream
curl "http://127.0.0.1:8000/dev/runtime/temporary-stream?fail=1"
```
