# Definition of Done

## Purpose

Definition of Done is the project contract for saying that a change is ready for review.

It does not replace engineering judgement. It removes the easiest ambiguity: a task is not done only because the page opened once in the browser.

## Local Readiness

Before a change is sent to review, the developer should be able to run:

```bash
make qa
```

At this stage `make qa` includes:

- basic environment and Composer checks;
- Laravel test suite;
- frontend build;
- Git diff whitespace check.

This list will grow during the course.

## Laravel Change Checklist

A normal backend change is done only when the relevant items are true:

- the command is run from the project root;
- database migrations are created and can be applied cleanly when the change needs schema updates;
- tests cover the changed business behavior or the risk is written down;
- frontend assets build when UI or assets changed;
- queue, mail, storage and Octane runtime effects are considered when the change touches them;
- documentation is updated when the workflow or project contract changed;
- sensitive data is not logged or committed;
- the review description names any remaining manual risk.

## Review Readiness

Review should focus on meaning, architecture and tradeoffs.

Review should not be the first place where the team discovers that Composer metadata is invalid, tests fail, frontend assets do not build, or the diff has avoidable formatting noise.

## Current Open Gaps

- Code style is not yet an explicit quality gate.
- Static analysis is not yet configured.
- Coverage is not yet reported.
- CI is not yet present.
- Health/readiness checks are not yet part of the quality command.
- Architecture checks are not yet automated.

These gaps are not hidden. They are the next course steps.
