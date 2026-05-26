# Parallel Tests Risk Notes

## Purpose

Parallel tests shorten the feedback loop, but they also expose hidden shared state.

The project uses:

```bash
make test-parallel
```

Laravel runs the test suite through ParaTest. Each worker needs isolated database state, filesystem assumptions and cache/session behavior that do not depend on test execution order.

## Risks To Watch

- Tests that depend on records created by another test.
- Tests that write to the same fixed file path.
- Tests that keep static state between requests.
- Tests that depend on global cache keys without cleanup.
- Tests that assume a queue, mail or notification state from earlier tests.
- Tests that pass alone but fail when several workers run at the same time.

## Current Decision

Parallel tests are part of the feedback loop, but they are not proof that tests are well isolated.

When a parallel run fails and a normal run passes, treat it as a signal. The failure usually points to shared state, order dependency or an environment assumption that was already risky.
