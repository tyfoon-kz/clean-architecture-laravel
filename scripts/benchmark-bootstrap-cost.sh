#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"

echo "FPM/bootstrap comparison. These routes are intentionally different; read the result as a local signal, not as a proof."
for route in "/dev/runtime/light" "/dev/runtime/products-count" "/catalog/cache-summary"; do
  for run in 1 2 3; do
    bash scripts/http_timing.sh "${BASE_URL}" "${route}"
  done
done
