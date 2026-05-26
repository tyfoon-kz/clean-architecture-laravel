# Quality Dashboard

## Local Quality Gate

```bash
make qa
```

Current checks:

- Pint style check;
- PHPStan/Larastan static analysis;
- architecture boundary guard;
- PHP version and Composer validation;
- Laravel test suite;
- frontend build;
- Git diff whitespace check.

## Supporting Commands

| Command | Purpose |
| --- | --- |
| `make format` | Apply PHP code style |
| `make lint-style` | Check PHP code style |
| `make analyse` | Run static analysis |
| `make rector-dry` | Preview mechanical refactoring |
| `make test` | Run normal test suite |
| `make test-parallel` | Run tests through ParaTest |
| `make test-coverage` | Produce coverage when Xdebug/PCOV is installed |
| `make test-architecture` | Run boundary checks |
| `make health` | Check liveness/readiness endpoints |

## CI Gate

`.github/workflows/quality.yml` runs `make qa` in a clean GitHub Actions runner.

## Runtime Signals

The project currently has:

- structured logs for product publication;
- `/up` liveness endpoint;
- `/health/ready` readiness endpoint;
- `docs/runtime-signals.md` as a bridge to the metrics course.

## Known Manual Risks

- Coverage driver may not be installed locally.
- Healthchecks do not replace metrics and alerts.
- Architecture guard protects only one boundary so far.
- Pre-commit hooks can be skipped and must not replace CI.
- Some business flows still rely on human review and focused future tests.

## Current Quality Position

The project has a usable quality pipeline. It is not perfect, but it has moved from scattered manual checks to a visible system of local checks, CI gate, first runtime signals and documented risks.
