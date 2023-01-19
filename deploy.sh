#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(docker exec -it which-track-app php artisan down) || true
    # Update codebase
    git fetch origin deploy
    git reset --hard origin/deploy

    # Install dependencies based on lock file
    docker exec -it which-track-app composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

    # Migrate database
    docker exec -it which-track-app php artisan migrate --force

    # Note: If you're using queue workers, this is the place to restart them.
    # ...

    # Clear cache
    docker exec -it which-track-app php artisan optimize
# Exit maintenance mode
docker exec -it which-track-app php artisan up

echo "Application deployed!"

