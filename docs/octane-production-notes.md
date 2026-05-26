# Octane Production Notes

Octane меняет не Laravel как фреймворк, а жизненный цикл PHP процесса.
В классическом FPM подходе приложение обычно загружается заново на каждый запрос.
В long-running worker приложение загружается один раз, затем один и тот же процесс обслуживает много запросов.

Поэтому production notes должны отвечать не только на вопрос "работает ли endpoint", но и на вопросы про reload, память, соединения, stale state, logs и smoke checks после deploy.


## Production Checklist

- Healthcheck route: `/up`, cheap and independent from expensive business work.
- Application smoke: `/` and one meaningful runtime route.
- Worker lifecycle: explicit reload or restart after deploy.
- Logs: FrankenPHP/Octane logs after reload, failed requests and worker restarts.
- Memory: current usage, peak usage, suspicious growth across repeated similar requests.
- Connections: first request after dependency failure, reconnect behavior and database logs if available.
- Assets: Vite build completed, manifest exists, browser receives current hashed assets.
- Limits: max requests and memory limits are guardrails, not substitutes for fixing leaks.

Green healthcheck and `restart: unless-stopped` do not explain incidents.
They only show that a process is currently reachable or has been restarted.
