# Testing Strategy

## Purpose

The test suite is a safety net, not a folder count.

Each test should answer a clear question:

- can a small business rule work without Laravel;
- can a Laravel feature route connect request, authorization, persistence and response;
- can infrastructure code talk to the database or another dependency correctly.

## Current Test Levels

### Unit and Domain Tests

Unit tests are used for rules that can be checked without Laravel bootstrapping the full application.

Current examples:

- `tests/Unit/ProductPublicationRuleTest.php`
- `tests/Unit/ProductPublicationPlainPhpTest.php`
- `tests/Unit/PublishProductServiceTest.php`
- `tests/Unit/RequiredAttributesTest.php`

These tests should stay fast and focused.

### Feature Tests

Feature tests are used when the question includes Laravel HTTP, database state, authentication, route behavior or framework integration.

Current examples:

- `tests/Feature/ProductPublicationAdapterTest.php`
- `tests/Feature/EloquentProductRepositoryTest.php`
- `tests/Feature/RuntimeReferenceTest.php`

These tests are slower, but they prove that the application wiring works.

### Integration Risks

The project still needs careful integration coverage around:

- queue jobs;
- mail and notification behavior;
- file uploads;
- Octane runtime smoke checks;
- health/readiness checks added later in this course.

## Critical Scenarios

The most important scenarios for this course are:

1. A product cannot be published without required attributes.
2. A product can be published when required attributes are filled.
3. Runtime diagnostic routes remain local/testing only.
4. Quality commands fail loudly when checks fail.

## Rule

Do not choose a test level by habit.
Choose it by the question the test must answer.
