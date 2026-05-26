# Project Root Contract

All commands in this repository are expected to run from the Laravel project root.
The root is the directory that contains:

```text
artisan
composer.json
package.json
Makefile
routes/
app/
database/
```

This matters more in the Octane course because several commands touch different layers at once:

- `php artisan ...` runs Laravel CLI code;
- `npm run build` writes frontend assets;
- `docker compose -f docker-compose.octane.yml ...` starts the runtime container;
- `make ...` names repeatable project workflows.

If a command is executed from the wrong directory, the error usually looks like a missing file problem:

```text
Could not open input file: artisan
No rule to make target
package.json not found
docker-compose.octane.yml not found
```

The fix is not to copy files into random folders.
The fix is to return to the project root and run the command from there.
