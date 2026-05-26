#!/usr/bin/env bash

set -euo pipefail

echo "Running fast pre-commit quality checks..."

make lint-style
make analyse
git diff --check

echo "Pre-commit quality checks passed."
