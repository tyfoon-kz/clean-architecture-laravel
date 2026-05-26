# Quality Commands

## Local Entrypoints

The project uses Make targets to keep repeated quality actions visible and repeatable.

```bash
make help
make check
make qa
```

`make check` is the basic smoke check. It verifies tool versions, validates Composer metadata and runs the Laravel test suite.

`make qa` is the quality entrypoint. At this stage it runs the style check, static analysis, `make check`, builds frontend assets and checks the Git diff for whitespace errors. It is intentionally still small. Later lessons add Rector, coverage and other checks to this same entrypoint.

`make format` applies Laravel Pint formatting. `make lint-style` runs Pint in check mode and fails when files need formatting.

`make analyse` runs PHPStan with Larastan. The current level is a starter contract, not the final strictness goal.

`make rector-dry` previews automated refactoring before any file is changed. `make rector` applies the diff only after the dry run looks safe.

## Current Contract

```text
make check -> basic local confidence
make format -> apply code style
make analyse -> static analysis feedback
make rector-dry -> preview mechanical refactoring
make qa     -> readiness check before commit or review
```

The important habit is not the exact list of commands on the first day. The important habit is that the project has one named quality command that can grow without forcing every developer to memorize a long sequence.
