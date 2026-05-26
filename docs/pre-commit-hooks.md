# Pre-commit Hooks

## Purpose

Pre-commit checks are a fast local filter.

They do not replace CI. A developer can skip a hook, forget to install it, or run a different local environment. CI remains the shared gate. The hook exists to catch cheap mistakes before a commit is created.

## Fast Check Script

The project provides:

```bash
scripts/pre-commit-quality.sh
```

It runs:

- `make lint-style`;
- `make analyse`;
- `git diff --check`.

It intentionally does not run the full frontend build or the whole heavy pipeline. A hook should be fast enough that developers keep it enabled.

## Optional Installation

```bash
ln -sf ../../scripts/pre-commit-quality.sh .git/hooks/pre-commit
chmod +x scripts/pre-commit-quality.sh
```

If the hook blocks a commit, fix the reported issue and commit again. If the hook must be bypassed for an emergency, CI still has to pass before merge.
