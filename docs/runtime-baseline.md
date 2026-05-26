# Runtime Baseline

Этот документ нужен как стартовая точка перед переходом на Laravel Octane и FrankenPHP.
Он не доказывает производительность приложения.
Он фиксирует, в каком состоянии проект находился до смены runtime, какие команды запускались и какие ограничения есть у локальной проверки.

## Project Context

- Project root: каталог, где рядом лежат `artisan`, `composer.json`, `package.json` и `Makefile`.
- Runtime before Octane: обычный Laravel HTTP lifecycle через `php artisan serve`, Docker/FPM или тот способ, который использует студент в своей среде.
- Important boundary: команды могут выполняться на host машине или внутри контейнера. В notes нужно явно писать, где запускалась каждая команда.

## Tool Versions To Record

```bash
php -v
composer --version
php artisan --version
docker --version
docker compose version
node --version
npm --version
make help
```

## Smoke Checks

```bash
make help
make check
make test
make build
curl -i http://127.0.0.1:8000/
curl -i http://127.0.0.1:8000/up
```

Если команда падает, результат не нужно превращать в зеленую галочку.
Нужно записать слой ошибки: PHP, Composer, Node, Docker, database, HTTP route, assets или test suite.

## Known Issues

- Без установленного `.env` приложение может не стартовать как полноценный web server.
- Без `npm install` frontend build не сможет собрать Vite assets.
- Без миграций routes, которые ходят в базу, могут падать или возвращать неожиданный результат.


## Benchmark Comparison

```bash
make benchmark-baseline
make benchmark-octane
```

Compare the same route shape under similar local conditions.
Do not claim that Octane speeds up SQL, external APIs, CPU-heavy work, N+1 queries or lock waits just because a light route became faster.
