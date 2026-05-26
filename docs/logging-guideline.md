# Logging Guideline

## Purpose

Logs should explain important runtime events.

They should not be a dump of everything the application knows. A useful log line has an event name, level and safe context that helps investigate a real scenario.

## Current Business Scenario

Product publication now writes structured logs:

- `product_publication_rejected` at warning level;
- `product_published` at info level.

The context includes:

- `product_id`;
- `actor_id`;
- rejection reason when publication fails.

## Sensitive Data Rule

Do not log passwords, tokens, raw request payloads, full session data, uploaded file contents, personal documents or secrets from `.env`.

Identifiers like `product_id` and `actor_id` are useful because they let the team connect the log entry to a database record without exposing the whole request.

## Level Rule

- Use `info` for expected important business events.
- Use `warning` for rejected or suspicious operations that the application handled.
- Use `error` when the application failed to complete a scenario and needs investigation.

## Future Work

Correlation ids are not fully wired yet. When the project gets request correlation middleware, logs should include `correlation_id` so one HTTP request can be followed across controllers, jobs and services.
