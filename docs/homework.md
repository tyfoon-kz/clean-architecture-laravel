# Homework Verification Notes

This repository keeps reference states for the Quality Pipeline and first observability course.

The important project artifacts are ordinary quality improvements:

- updated `Makefile` targets;
- quality notes under `docs`;
- formatter, analysis and Rector configuration;
- testing strategy and coverage artifacts;
- GitHub Actions workflow;
- local hook setup notes;
- structured logging examples;
- health/readiness checks;
- architecture quality rules;
- final quality dashboard and defense notes.

## Common Checks

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run build
make help
make check
make qa
```

## Safety Notes

- `.env` and real secrets must not be committed.
- Quality tools should be added gradually and explained through the risk they close.
- Coverage is a signal, not proof that the business scenario is protected.
- Pre-commit hooks do not replace CI.
- Healthchecks do not replace logs, metrics and incident investigation.
