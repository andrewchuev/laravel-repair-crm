#!/usr/bin/env sh
set -eu

cd /var/www/html

cat > /usr/local/etc/php/conf.d/99-runtime.ini <<EOF
memory_limit=${PHP_MEMORY_LIMIT:-512M}
max_execution_time=${PHP_MAX_EXECUTION_TIME:-120}
upload_max_filesize=${PHP_UPLOAD_MAX_FILESIZE:-32M}
post_max_size=${PHP_POST_MAX_SIZE:-32M}
date.timezone=${APP_TIMEZONE:-Europe/Kyiv}
EOF

mkdir -p   storage/app   storage/app/public   storage/framework/cache   storage/framework/sessions   storage/framework/views   storage/logs   bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache || true

if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

if [ "${APP_RUN_MIGRATIONS:-false}" = "true" ]; then
  php artisan migrate --force
fi

if [ "${APP_RUN_OPTIMIZE:-true}" = "true" ]; then
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
fi

exec "$@"
