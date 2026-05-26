#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"

echo "Baseline benchmark. Keep the runtime unchanged while collecting this output."
for route in "/" "/up" "/catalog/cache-summary"; do
  bash scripts/http_timing.sh "${BASE_URL}" "${route}"
done

php artisan test --filter=ReferenceSolutionTest
