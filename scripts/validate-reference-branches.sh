#!/usr/bin/env bash
set -euo pipefail

branch_map="${1:-docs/branch-map.md}"

if [[ ! -f "$branch_map" ]]; then
  echo "Branch map not found: $branch_map" >&2
  exit 1
fi

expected_branches=()

while IFS= read -r branch; do
  expected_branches+=("$branch")
done < <(
  grep -Eo '`lesson-v1-[^`]+`' "$branch_map" \
    | tr -d '`' \
    | grep -v '<' \
    | sort -u
)

missing=()

for branch in "${expected_branches[@]}"; do
  if ! git show-ref --verify --quiet "refs/heads/$branch"; then
    missing+=("$branch")
  fi
done

echo "Expected lesson branches: ${#expected_branches[@]}"
echo "Existing local lesson branches: $(git branch --list 'lesson-v1-*' | wc -l | tr -d ' ')"

if (( ${#missing[@]} > 0 )); then
  echo "Missing homework branches:"
  printf '  %s\n' "${missing[@]}"
  exit 1
fi

echo "All lesson branches from $branch_map exist locally."
