#!/usr/bin/env bash

set -euo pipefail

BASE_URL="${APP_URL:-http://127.0.0.1:8000}"

curl --fail --silent --show-error "${BASE_URL}/up" >/dev/null
curl --fail --silent --show-error "${BASE_URL}/health/ready"
echo
