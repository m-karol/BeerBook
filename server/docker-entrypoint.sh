#!/bin/sh
set -e

until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER" >/dev/null 2>&1; do
    sleep 1
done

echo "Running migrations..."
php migrations/init.php

echo "Starting PHP server..."
exec php -S 0.0.0.0:8080 -t public
