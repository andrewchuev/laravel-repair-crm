#!/usr/bin/env bash
set -Eeuo pipefail

REPO_DIR="${REPO_DIR:-/opt/sites/crm.reslab.pro}"
TARGET_SHA="${TARGET_SHA:-}"
APP_HEALTHCHECK_URL="${APP_HEALTHCHECK_URL:-http://127.0.0.1:10005/up}"

if [[ -z "${TARGET_SHA}" ]]; then
  echo "ERROR: TARGET_SHA is required."
  exit 1
fi

cd "${REPO_DIR}"

mkdir -p .deploy
exec 9> .deploy/deploy.lock
flock -n 9 || {
  echo "Another deploy is already running."
  exit 1
}

echo "==> Rollback started at $(date -Is)"
echo "==> Target SHA: ${TARGET_SHA}"

git fetch --prune origin
git reset --hard "${TARGET_SHA}"

ROLLBACK_COMMIT="$(git rev-parse HEAD)"
echo "==> Current commit after rollback reset: ${ROLLBACK_COMMIT}"

docker compose --env-file .env build app web
docker compose --env-file .env up -d app web queue scheduler

docker compose --env-file .env exec -T app php artisan optimize:clear
docker compose --env-file .env exec -T app php artisan config:cache
docker compose --env-file .env exec -T app php artisan route:cache
docker compose --env-file .env exec -T app php artisan view:cache

echo "==> Waiting for healthcheck: ${APP_HEALTHCHECK_URL}"
for i in {1..30}; do
  if curl --silent --fail --max-time 5 "${APP_HEALTHCHECK_URL}" >/dev/null; then
    echo "==> Rollback healthcheck passed"
    echo "${ROLLBACK_COMMIT}" > .deploy/last_successful_commit
    echo "==> Rollback completed successfully at $(date -Is)"
    exit 0
  fi

  echo "Healthcheck not ready yet (${i}/30)"
  sleep 2
done

echo "ERROR: healthcheck failed after rollback"
exit 1
