# CI Quality Pipeline

## Purpose

CI is the shared quality gate for the project.

Local checks are still useful because they shorten feedback. CI is different because it runs in a clean environment and gives the team one shared result.

## Workflow

The project uses:

```text
.github/workflows/quality.yml
```

The workflow installs PHP and Node dependencies, prepares the Laravel application and runs:

```bash
make qa
```

This keeps the CI workflow close to the local developer workflow. When `make qa` grows, CI follows the same project contract instead of duplicating a hidden command sequence.

## Current Scope

The quality workflow currently covers:

- Pint style check;
- PHPStan/Larastan static analysis;
- Composer validation;
- Laravel tests;
- frontend build;
- Git diff whitespace check.

Coverage, healthchecks and architecture guards are added later as separate course steps.
