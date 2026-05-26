# Quality Pipeline Observability Reference

This repository contains the reference implementation for the Quality Pipeline and first observability course.

The project starts from the finished Laravel/Filament catalog application after the Octane and FrankenPHP course. This course keeps the same product catalog domain and adds a quality-focused learning path:

- current project quality baseline;
- repeatable `make qa` workflow;
- Laravel Pint formatting checks;
- PHPStan/Larastan static analysis;
- controlled Rector refactoring;
- testing strategy, coverage and parallel tests;
- GitHub Actions quality pipeline;
- local pre-commit checks;
- structured logging;
- health and readiness checks;
- runtime signal notes;
- architecture guards;
- final quality dashboard and defense.

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
php artisan test
```

Useful project commands:

```bash
make help
make check
make qa
make build
make test
```

The Octane/FrankenPHP runtime from the previous course remains available because this course builds quality checks around an already production-oriented Laravel project.
