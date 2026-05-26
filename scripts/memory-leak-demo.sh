#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${1:-http://127.0.0.1:8000}"

curl -s -X POST "${BASE_URL}/dev/runtime/memory-leak/reset" > /dev/null
for i in $(seq 1 10); do
  curl -s "${BASE_URL}/dev/runtime/memory-leak?kb=128"
  echo
done
