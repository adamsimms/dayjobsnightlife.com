#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

OLD_URL="${1:-}"
NEW_URL="${2:-http://localhost:8080}"
SQL_FILE="${3:-$ROOT_DIR/backups/database.sql}"
WP_PORT="${WP_PORT:-8080}"

usage() {
  cat <<'EOF'
Restore a DreamHost WordPress export into local Docker.

Usage:
  ./scripts/restore.sh <old-url> [new-url] [sql-file]

Examples:
  ./scripts/restore.sh https://dayjobsnightlife.com
  ./scripts/restore.sh https://www.dayjobsnightlife.com http://localhost:8080 backups/database.sql
  ./scripts/restore.sh http://dayjobsnightlife.com https://dayjobsnightlife.dreamhosters.com

Before running:
  1. Put your MySQL export at backups/database.sql
  2. Copy wp-content/uploads and wp-content/plugins from DreamHost into backups/wp-content/
  3. Optional: copy the active theme into backups/wp-content/themes/ if it differs from ./theme

What this script does:
  - starts WordPress + MySQL in Docker
  - imports the SQL dump
  - replaces old URLs with the new URL (including serialized data)
  - activates the dayjobsnightlife theme when available
EOF
}

if [[ "${OLD_URL}" == "-h" || "${OLD_URL}" == "--help" || -z "${OLD_URL}" ]]; then
  usage
  exit 0
fi

if [[ ! -f "$SQL_FILE" ]]; then
  echo "Missing database dump: $SQL_FILE"
  echo "Export it from DreamHost phpMyAdmin and save it as backups/database.sql"
  exit 1
fi

mkdir -p backups/wp-content/uploads backups/wp-content/plugins backups/wp-content/themes theme

if [[ ! -f theme/style.css ]]; then
  echo "Syncing theme files into ./theme ..."
  mkdir -p theme
  for path in 404.php base.php functions.php home.php index.php page.php single.php search.php searchform.php style.css screenshot.png template-custom.php assets lib lang templates; do
    if [[ -e "$path" ]]; then
      cp -a "$path" theme/
    fi
  done
fi

export WP_HOME="$NEW_URL"
export WP_SITEURL="$NEW_URL"
export WP_PORT

echo "Starting containers ..."
docker compose up -d db wordpress

echo "Waiting for database ..."
for _ in $(seq 1 60); do
  if docker compose exec -T db mysqladmin ping -h localhost -uroot -proot --silent 2>/dev/null; then
    break
  fi
  sleep 2
done

echo "Importing database from $SQL_FILE ..."
docker compose exec -T db mysql -uroot -proot -e "DROP DATABASE IF EXISTS wordpress; CREATE DATABASE wordpress;"
docker compose exec -T db mysql -uroot -proot wordpress < "$SQL_FILE"

echo "Replacing URLs:"
echo "  $OLD_URL -> $NEW_URL"
docker compose run --rm --no-deps wpcli search-replace "$OLD_URL" "$NEW_URL" --all-tables --skip-columns=guid

OLD_URL_NO_SCHEME="${OLD_URL#https://}"
OLD_URL_NO_SCHEME="${OLD_URL_NO_SCHEME#http://}"
NEW_URL_NO_SCHEME="${NEW_URL#https://}"
NEW_URL_NO_SCHEME="${NEW_URL_NO_SCHEME#http://}"

if [[ "$OLD_URL_NO_SCHEME" != "$OLD_URL" ]]; then
  docker compose run --rm --no-deps wpcli search-replace "$OLD_URL_NO_SCHEME" "$NEW_URL_NO_SCHEME" --all-tables --skip-columns=guid || true
fi

if [[ "$OLD_URL" == *"www."* ]]; then
  ALT_OLD="${OLD_URL/www./}"
  echo "Also replacing $ALT_OLD"
  docker compose run --rm --no-deps wpcli search-replace "$ALT_OLD" "$NEW_URL" --all-tables --skip-columns=guid || true
else
  ALT_OLD="${OLD_URL/https:\/\//https://www.}"
  ALT_OLD="${ALT_OLD/http:\/\//http://www.}"
  echo "Also replacing $ALT_OLD"
  docker compose run --rm --no-deps wpcli search-replace "$ALT_OLD" "$NEW_URL" --all-tables --skip-columns=guid || true
fi

docker compose run --rm --no-deps wpcli option update home "$NEW_URL"
docker compose run --rm --no-deps wpcli option update siteurl "$NEW_URL"
docker compose run --rm --no-deps wpcli rewrite flush --hard

if docker compose run --rm --no-deps wpcli theme is-installed dayjobsnightlife >/dev/null 2>&1; then
  docker compose run --rm --no-deps wpcli theme activate dayjobsnightlife || true
fi

echo
echo "Restore complete."
echo "Open: $NEW_URL"
echo
echo "If styles are missing, build the theme assets:"
echo "  cd theme && npm install && npm run build"
echo
echo "Useful commands:"
echo "  docker compose logs -f wordpress"
echo "  docker compose run --rm wpcli plugin list"
echo "  docker compose down"
