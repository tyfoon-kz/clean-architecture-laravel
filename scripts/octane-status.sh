#!/usr/bin/env bash
set -euo pipefail

echo "Docker containers for Octane/FrankenPHP compose file:"
docker compose -f docker-compose.octane.yml ps || true

echo
echo "Recent FrankenPHP logs:"
docker compose -f docker-compose.octane.yml logs --tail=80 app || true
