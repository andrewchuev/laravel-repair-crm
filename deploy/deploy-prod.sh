#!/usr/bin/env bash
set -Eeuo pipefail

REPO_DIR="${REPO_DIR:-/opt/sites/crm.reslab.pro}"
DEPLOY_BRANCH="${DEPLOY_BRANCH:-main}"
DEPLOY_SHA="${DEPLOY_SHA:-}"
APP_HEALTHCHECK_URL="${APP_HEALTHCHECK_URL:-http://127.0.0.1:10005/up}"

cd "${REPO_DIR}"

mkdir -p .deploy
exec 9> .deploy/deploy.lock
flock -n 9 || {
  echo "Another deploy is already running."
  exit 1
}

echo "==> Deploy started at $(date -Is)"
echo "==> Repo dir: ${REPO_DIR}"

if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "ERROR: ${REPO_DIR} is not a git repository."
  exit 1
fi

PREVIOUS_COMMIT="$(git rev-parse HEAD)"
echo "${PREVIOUS_COMMIT}" > .deploy/previous_commit

echo "==> Fetching remote changes"
git fetch --prune origin

if [[ -n "${DEPLOY_SHA}" ]]; then
  TARGET="${DEPLOY_SHA}"
else
  TARGET="origin/${DEPLOY_BRANCH}"
fi

echo "==> Resetting working tree to ${TARGET}"
git reset --hard "${TARGET}"

CURRENT_COMMIT="$(git rev-parse HEAD)"
echo "==> Current commit: ${CURRENT_COMMIT}"

echo "==> Starting data services"
docker compose --env-file .env up -d db redis

echo "==> Building application images on server"
docker compose --env-file .env build app web

echo "==> Starting application services"
docker compose --env-file .env up -d app web queue scheduler

echo "==> Running Laravel post-deploy commands"
docker compose --env-file .env exec -T app php artisan migrate --force
docker compose --env-file .env exec -T app php artisan optimize:clear
docker compose --env-file .env exec -T app php artisan config:cache
docker compose --env-file .env exec -T app php artisan route:cache
docker compose --env-file .env exec -T app php artisan view:cache

echo "==> Waiting for healthcheck: ${APP_HEALTHCHECK_URL}"
for i in {1..30}; do
  if curl --silent --fail --max-time 5 "${APP_HEALTHCHECK_URL}" >/dev/null; then
    echo "==> Healthcheck passed"
    echo "${CURRENT_COMMIT}" > .deploy/last_successful_commit
    echo "==> Deploy completed successfully at $(date -Is)"
    exit 0
  fi

  echo "Healthcheck not ready yet (${i}/30)"
  sleep 2
done

echo "ERROR: healthcheck failed after deploy"
exit 1
