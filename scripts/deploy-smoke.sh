#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"

echo "Deploy smoke after Octane reload/restart"
bash scripts/http_timing.sh "${BASE_URL}" "/up"
bash scripts/http_timing.sh "${BASE_URL}" "/"
bash scripts/http_timing.sh "${BASE_URL}" "/dev/runtime/light"
