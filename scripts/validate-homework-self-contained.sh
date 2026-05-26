#!/usr/bin/env bash
set -euo pipefail

repo_dir="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
course_dir="$(cd "$repo_dir/.." && pwd)"
modules_dir="$course_dir/modules"

failures=0

report_failure() {
  echo "FAIL: $*" >&2
  failures=$((failures + 1))
}

while IFS= read -r file; do
  if ! grep -q '```' "$file"; then
    report_failure "$file has no fenced command/example block"
    continue
  fi

  if ! grep -Eqi '\b(php|composer|curl|docker|psql|artisan|git|vendor/bin|phpunit|pest|test -f|find |diff --check)\b' "$file"; then
    report_failure "$file has no explicit local command words"
  fi
done < <(find "$modules_dir" -path '*/lessons/*/homework.md' -type f | sort)

if (( failures > 0 )); then
  echo "Homework self-contained validation failed with $failures issue(s)." >&2
  exit 1
fi

echo "Homework self-contained validation passed."
