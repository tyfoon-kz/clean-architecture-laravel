#!/usr/bin/env bash

set -euo pipefail

if ! php -m | grep -Eiq 'xdebug|pcov'; then
  cat <<'MESSAGE'
Coverage driver is not available.

Install or enable Xdebug/PCOV before running coverage:
- Xdebug: https://xdebug.org/docs/code_coverage
- PCOV: https://github.com/krakjoe/pcov

The normal test suite still runs through:
  make test
MESSAGE
  exit 1
fi

XDEBUG_MODE=coverage php artisan test --coverage --min=0
