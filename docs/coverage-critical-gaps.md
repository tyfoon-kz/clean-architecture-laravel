# Coverage Critical Gaps

## Purpose

Coverage is a map of executed code, not proof that the project is correct.

This document records the first coverage workflow and the business scenarios that deserve attention even when the percentage looks acceptable.

## Command

```bash
make test-coverage
```

The command requires Xdebug or PCOV. If neither coverage driver is installed, the script fails with a clear message instead of pretending that coverage was measured.

## Critical Paths

These scenarios are more important than a raw percentage:

1. Publishing a product must fail when required attributes are missing.
2. Publishing a product must succeed when required attributes are filled.
3. Product publication must write an audit event.
4. Runtime diagnostic routes must remain restricted to local/testing environments.
5. Future health/readiness checks must report dependency failures clearly.

## Current Decision

The project will use coverage as a risk signal. A higher percentage is useful only when it protects meaningful behavior. A low percentage around a critical business flow is more important than uncovered boilerplate.
