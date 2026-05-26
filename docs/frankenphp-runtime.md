# FrankenPHP Runtime Config

FrankenPHP combines a web server layer with PHP execution.
In this course it is used through Laravel Octane so that the application can run as a long-running worker.

Important boundaries:

- Laravel code still lives in the application.
- Octane manages the worker lifecycle.
- FrankenPHP is the server/runtime driver.
- Docker Compose starts the local service and maps the external port.

The health endpoint for this app is `/up`.
It should stay cheap because healthchecks are not a replacement for real observability.
