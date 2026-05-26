# Quality Baseline

## Project Point

- Course stage: quality pipeline baseline.
- Source project state: finished Laravel/Filament catalog after Octane and FrankenPHP runtime work.
- Main goal: record what the project can already check before adding new quality gates.

## Local Commands

| Command | Purpose | Expected Result | Current Status |
| --- | --- | --- | --- |
| `make help` | Shows available project commands | Command list is printed | Pending local run |
| `make check` | Runs smoke checks and tests | PHP, Composer, validation and tests pass | Pending local run |
| `make test` | Runs Laravel test suite | Test suite passes | Pending local run |
| `make build` | Builds frontend assets | Vite build succeeds | Pending local run |
| `make qa` | Runs the local quality entrypoint | Smoke checks, frontend build and diff check pass | Added in lesson 00-02 |
| `make lint-style` | Checks PHP code style through Laravel Pint | Pint reports no formatting changes needed | Added in lesson 02-01 |
| `make format` | Applies Laravel Pint formatting | PHP files are formatted | Added in lesson 02-01 |
| `make analyse` | Runs PHPStan/Larastan static analysis | Static analysis passes at the configured level | Added in lesson 02-02 |
| `make rector-dry` | Previews Rector automated refactoring | Rector shows an empty or reviewable diff | Added in lesson 02-03 |
| `make rector` | Applies Rector automated refactoring | Only reviewed mechanical changes are applied | Added in lesson 02-03 |
| `make test-coverage` | Runs PHPUnit coverage when Xdebug/PCOV is installed | Coverage report is produced or missing driver is explained | Added in lesson 03-02 |
| `make test-parallel` | Runs Laravel tests in parallel through ParaTest | Test suite passes without shared-state flakes | Added in lesson 03-03 |
| `make deploy-smoke` | Runs cheap runtime smoke checks | Runtime endpoints respond | Optional runtime check |
| GitHub Actions `quality.yml` | Runs shared CI quality gate | `make qa` passes in a clean runner | Added in lesson 04-01 |
| `scripts/pre-commit-quality.sh` | Runs fast local pre-commit checks | Style, static analysis and diff check pass | Added in lesson 04-02 |
| `docs/pr-readiness.md` | Defines review readiness checklist | Review request names checks and remaining risks | Added in lesson 04-03 |
| `docs/logging-guideline.md` | Defines structured logging rules | Important scenario logs safe context | Added in lesson 05-01 |
| `/health/ready` and `make health` | Checks readiness dependencies | Database/cache readiness is reported | Added in lesson 05-02 |
| `docs/runtime-signals.md` | Maps first runtime signals | Signals have source and future metric candidate | Added in lesson 05-03 |
| `make test-architecture` | Runs architecture boundary checks | Presentation layer avoids catalog infrastructure dependency | Added in lesson 06-01 |
| `docs/architecture-quality-rules.md` | Explains architecture and quality rules | Rules are tied to concrete risks | Expanded in lesson 06-02 |
| `docs/quality-dashboard.md` | Summarizes the quality system | Checks, CI, runtime signals and risks are visible | Added in lesson 07-01 |
| `docs/quality-defense.md` | Defends the final quality pipeline | Automatic and manual risks are explained | Added in lesson 07-02 |

## Existing Safety Net

- Laravel feature tests cover product publication through the HTTP adapter.
- Unit tests cover the product publication application service and domain rules.
- Runtime tests cover local diagnostic endpoints from the Octane course.
- `composer validate --strict` is part of the existing `make check`.
- `git diff --check` is available through `make qa`.
- Frontend build exists through `npm run build` and `make build`.
- `make qa` now combines the existing backend checks, frontend build and whitespace diff check.
- Laravel Pint is now the explicit formatter for PHP code style.
- PHPStan/Larastan is now configured at a starter level so the project can grow strictness deliberately.
- Rector is now configured for controlled automated refactoring through dry-run and apply targets.
- The testing strategy now separates unit/domain questions from Laravel feature and integration questions.
- Coverage has a repeatable command and a critical gap document.
- Parallel tests are available as a faster feedback loop and documented as a shared-state risk detector.
- CI now repeats the local `make qa` quality gate in GitHub Actions.
- Pre-commit fast checks are documented as a local filter, not as a replacement for CI.
- PR readiness now has a short checklist and review description template.
- Product publication now has structured logs and a logging guideline.
- Readiness checks now verify database and cache dependency paths.
- Runtime signals are mapped as a bridge to the metrics course.
- Architecture guard checks one boundary between presentation code and catalog infrastructure.
- Quality rules now describe the risk they protect instead of acting as taste-based restrictions.
- Quality dashboard summarizes the full local, CI, runtime and manual risk picture.
- Quality defense explains what the pipeline catches and what still remains manual.

## Known Gaps Before This Course

- `make qa` is intentionally small at the start of the course and will grow as the project gains quality gates.
- Formatting is now explicit through `make format` and `make lint-style`.
- Static analysis is configured at a starter level and should become stricter over time.
- Rector is configured, but each diff still requires human review before commit.
- Coverage reporting is documented and requires Xdebug or PCOV in the local environment.
- Parallel tests are documented and available through `make test-parallel`.
- CI workflow is present and follows the local `make qa` contract.
- Pre-commit checks are documented and available through `scripts/pre-commit-quality.sh`.
- Structured logging rules are documented for product publication.
- Health/readiness checks are available through `/health/ready` and `make health`.
- First architecture guard is configured through `make test-architecture`.

## Baseline Decision

The project starts this course from a working runtime-focused state. The next changes should not hide behind new tools. Each added check must explain which risk it closes, how it is run locally, and whether CI repeats it.
