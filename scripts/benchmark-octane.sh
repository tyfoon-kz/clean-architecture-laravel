#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"

echo "Octane benchmark. Compare only with the same routes and similar local conditions."
for route in "/dev/runtime/light" "/dev/runtime/products-count" "/catalog/cache-summary"; do
  for run in 1 2 3; do
    bash scripts/http_timing.sh "${BASE_URL}" "${route}"
  done
done
