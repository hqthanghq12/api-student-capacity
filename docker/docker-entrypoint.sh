#!/bin/sh
set -e

if [ -n "${USER_ID}" ]; then
    usermod -u "${USER_ID}" -o www-data
fi
if [ -n "${GROUP_ID}" ]; then
    groupmod -g "${GROUP_ID}" www-data
fi

#if [ ! -d /var/www/html/vendor/bin ]; then
    composer install \
        --no-scripts \
        --no-autoloader \
        --no-plugins
    composer dump-autoload
    chown -R www-data: vendor
#fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

# If app_env is not production, generate key
if [ "${APP_ENV}" != "production" ]; then
    php artisan key:generate
fi

# clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache

# migrate data
php artisan migrate

# build assets
npm install -f

# mix assets
npx mix

# Enable Laravel schedule
if [[ "${ENABLE_CRONTAB:-0}" = "1" ]]; then
  mv -f /etc/supervisor.d/cron.conf.default /etc/supervisor.d/cron.conf
  echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/www-data
fi

# Enable Laravel queue workers
if [[ "${ENABLE_WORKER:-0}" = "1" ]]; then
  mv -f /etc/supervisor.d/worker.conf.default /etc/supervisor.d/worker.conf
else
  rm -f /etc/supervisor.d/worker.conf.default
fi

exec "$@"
