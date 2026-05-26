# Architecture Quality Rules

## Rule 1: Presentation Does Not Reach Into Catalog Infrastructure

Controllers and Filament resources should talk to application services, requests, resources and framework adapters.

They should not directly depend on `App\Catalog\Infrastructure`.

Why: direct infrastructure usage from presentation code hides business flow wiring and makes DDD-lite boundaries easier to bypass.

How it is checked:

```bash
make test-architecture
```

## Current Scope

The first architecture guard is intentionally small. It protects one visible risk instead of pretending that the whole architecture can be proven automatically.

## Rule 2: Quality Commands Stay In Makefile

Repeated local checks should be available through named Make targets.

Why: a quality rule that exists only in a lesson, chat message or developer memory will not survive normal project work.

How it is checked now: `make help` must show the quality commands that the course relies on.

## Rule 3: CI Reuses The Local Quality Contract

CI should run the same project-level quality entrypoint that developers run locally.

Why: when CI has a hidden command sequence, the local workflow and shared gate drift apart. Drift creates "works locally but fails in CI" frustration and weakens trust in the pipeline.

How it is checked now: `.github/workflows/quality.yml` runs `make qa`.

## Rule 4: Quality Rules Must Explain Their Risk

Every new guard should have a short reason in `docs`.

Why: rules without a named risk become architecture taste. Taste is not enough to justify a failing build.

How it is checked now: this document records the rule, the risk and the verification path.
