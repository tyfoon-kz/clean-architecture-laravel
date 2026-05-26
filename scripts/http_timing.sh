#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"
PATH_TO_CHECK="${2:-/}"

curl -o /dev/null -s -w "route=${PATH_TO_CHECK} status=%{http_code} time_total=%{time_total}\n" "${BASE_URL}${PATH_TO_CHECK}"
