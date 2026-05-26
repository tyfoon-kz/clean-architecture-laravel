# Course Escalation

This course continues from an already working Laravel/Filament catalog application running with Octane and FrankenPHP.

The previous project changed the runtime question:

```text
Can the same Laravel application run safely when PHP does not forget everything after every request?
```

This course changes the quality question:

```text
Can the same Laravel application prove that a change is ready before it reaches users?
```

The main escalation is not a new business domain. The product catalog remains the same on purpose. The engineering work moves around the project:

- repeatable local quality commands;
- formatter and static analysis;
- safe automated refactoring;
- testing strategy and coverage signals;
- CI as a shared team gate;
- pre-commit as a fast local filter;
- structured logs and healthchecks;
- architecture guards;
- final quality dashboard.

The goal is to make quality observable before merge and partially visible at runtime.
