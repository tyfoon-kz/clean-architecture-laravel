.PHONY: deptrac architecture-check help install test check qa format lint-style analyse rector-dry rector test-coverage test-parallel test-architecture health migrate migrate-status build diff-check benchmark-baseline bootstrap-cost octane-up octane-down octane-logs octane-reload octane-watch front race-demo locking-demo memory-leak-demo octane-status benchmark-octane deploy-smoke metrics-help metrics-up metrics-down metrics-logs metrics-check metrics-redis-cli prometheus-targets grafana-open metrics-demo queue-demo

OBSERVABILITY_COMPOSE=docker-compose.observability.yml

help: ## Show available project commands
	@grep -E '^[a-zA-Z0-9_-]+:.*?## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "%-22s %s\n", $$1, $$2}'

install: ## Install PHP and frontend dependencies
	composer install
	npm install

test: ## Run Laravel test suite
	php artisan test

test-coverage: ## Run tests with coverage report when a coverage driver is installed
	bash scripts/test-coverage.sh

test-parallel: ## Run Laravel tests in parallel
	php artisan test --parallel

test-architecture: ## Run architecture boundary checks
	php artisan test tests/Architecture

health: ## Check liveness and readiness endpoints
	bash scripts/health.sh

check: ## Run smoke checks for the Laravel/Filament project
	php -v
	composer --version
	composer validate --strict
	php artisan --version
	npm --version
	$(MAKE) test

qa: lint-style analyse test-architecture check build diff-check ## Run the local quality entrypoint

format: ## Format PHP code with Laravel Pint
	./vendor/bin/pint

lint-style: ## Check PHP code style without changing files
	./vendor/bin/pint --test

analyse: ## Run PHPStan/Larastan static analysis
	./vendor/bin/phpstan analyse --memory-limit=1G

rector-dry: ## Preview Rector automated refactoring diff
	./vendor/bin/rector process --dry-run

rector: ## Apply Rector automated refactoring
	./vendor/bin/rector process

migrate: ## Apply database migrations
	php artisan migrate

migrate-status: ## Show Laravel migration status
	php artisan migrate:status

build: ## Build frontend assets
	npm run build

diff-check: ## Check whitespace errors in git diff
	git diff --check

benchmark-baseline: ## Measure baseline HTTP routes before Octane
	bash scripts/benchmark-baseline.sh

bootstrap-cost: ## Compare light and database routes in the classic lifecycle
	bash scripts/benchmark-bootstrap-cost.sh

octane-up: ## Start FrankenPHP/Octane runtime through Docker Compose
	docker compose -f docker-compose.octane.yml up -d app

octane-down: ## Stop FrankenPHP/Octane runtime
	docker compose -f docker-compose.octane.yml down

octane-logs: ## Follow FrankenPHP/Octane logs
	docker compose -f docker-compose.octane.yml logs -f app

octane-reload: ## Reload Octane workers after code or config changes
	php artisan octane:reload --server=frankenphp

octane-watch: ## Start Octane in local watch mode
	php artisan octane:start --server=frankenphp --host=127.0.0.1 --port=8000 --watch

front: ## Build frontend assets and reload Octane workers
	npm run build
	$(MAKE) octane-reload

race-demo: ## Run local lost update demonstration
	php scripts/race-demo.php

locking-demo: ## Run locked counter demonstration
	php scripts/locking-tradeoff-demo.php

memory-leak-demo: ## Call local memory leak endpoint repeatedly
	bash scripts/memory-leak-demo.sh

octane-status: ## Show Octane container status and recent logs
	bash scripts/octane-status.sh

benchmark-octane: ## Measure the same routes under Octane runtime
	bash scripts/benchmark-octane.sh

deploy-smoke: ## Run cheap smoke checks after reload or deploy
	bash scripts/deploy-smoke.sh

metrics-help: ## Show observability workflow notes
	@echo "Observability workflow:"
	@echo "  make metrics-up          start Prometheus/Grafana stack when compose config exists"
	@echo "  make metrics-check       check the local metrics endpoint"
	@echo "  make metrics-logs        follow observability stack logs"
	@echo "  make metrics-redis-cli   inspect Redis used by the metrics store"
	@echo "  make prometheus-targets  show Prometheus targets endpoint"
	@echo "  make grafana-open        print Grafana local URL"

metrics-up: ## Start observability stack
	@test -f $(OBSERVABILITY_COMPOSE) || (echo "$(OBSERVABILITY_COMPOSE) will be added in the Prometheus module."; exit 0)
	docker compose -f docker-compose.octane.yml -f $(OBSERVABILITY_COMPOSE) up -d app prometheus grafana

metrics-down: ## Stop observability stack
	@test -f $(OBSERVABILITY_COMPOSE) || (echo "$(OBSERVABILITY_COMPOSE) is not present yet."; exit 0)
	docker compose -f docker-compose.octane.yml -f $(OBSERVABILITY_COMPOSE) down

metrics-logs: ## Follow observability stack logs
	@test -f $(OBSERVABILITY_COMPOSE) || (echo "$(OBSERVABILITY_COMPOSE) is not present yet."; exit 0)
	docker compose -f docker-compose.octane.yml -f $(OBSERVABILITY_COMPOSE) logs -f redis prometheus grafana

metrics-check: ## Check the application metrics endpoint
	curl -fsS http://127.0.0.1:$${OCTANE_PORT:-8000}/metrics | head -40

metrics-redis-cli: ## Open redis-cli inside the observability Redis service
	docker compose -f docker-compose.octane.yml -f $(OBSERVABILITY_COMPOSE) exec redis redis-cli

prometheus-targets: ## Show Prometheus targets API response
	curl -fsS http://127.0.0.1:9090/api/v1/targets | head -80

grafana-open: ## Print Grafana local URL
	@echo "Grafana: http://127.0.0.1:3000"

metrics-demo: ## Call a few demo routes to generate HTTP metrics
	curl -fsS http://127.0.0.1:$${OCTANE_PORT:-8000}/ >/dev/null
	curl -fsS http://127.0.0.1:$${OCTANE_PORT:-8000}/health/ready >/dev/null
	curl -fsS http://127.0.0.1:$${OCTANE_PORT:-8000}/dev/runtime/light >/dev/null

queue-demo: ## Dispatch a demo queue workload for metrics practice
	php artisan tinker --execute="App\\Jobs\\RecalculateProductSearchIndex::dispatch(App\\Models\\Product::query()->value('id') ?? 1);"


deptrac: ## Run Deptrac dependency rules
	./vendor/bin/deptrac analyse --config-file=deptrac.yaml

architecture-check: deptrac test-architecture ## Run architecture checks
