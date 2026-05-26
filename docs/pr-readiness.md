# PR Readiness

## Purpose

Review starts before another person opens the diff.

This document keeps the review request focused on meaning instead of basic avoidable failures.

## Before Opening Review

Run:

```bash
make qa
```

Then check the relevant items:

- database migrations are included when schema changes;
- tests cover the changed behavior or the risk is written down;
- frontend build is relevant and passes when UI changed;
- logs do not expose sensitive data;
- Octane reload/restart impact is considered when config, routes, services or assets changed;
- documentation changed when the workflow changed.

## Review Description Template

```text
What changed:

Why it changed:

How I checked it:
- make qa
- other focused checks:

Known risks:

Manual review focus:
```

## Rule

Do not hide uncertainty.

If a risk is still manual, write it down. A clear risk note is better than pretending the pipeline proves something it does not check yet.
