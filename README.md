# Curso Testing

# Permissions

find /Users/work/Sites/CursoTesting/ -type d -exec chmod 755 {} \;
find /Users/work/Sites/CursoTesting/ -type f -exec chmod 644 {} \;

# Build
docker-compose -f ./docker/docker-compose.yml build

# Run
docker-compose -f ./docker/docker-compose.yml up

# Stop
docker-compose -f ./docker/docker-compose.yml down

# Get into the Php Container as www-data user
docker exec -it -u www-data curso_testing_php_fpm /bin/bash

# Prepare web assets
php bin/console assets:install --symlink

# Initialize tables
XDEBUG_MODE=off php bin/console doctrine:schema:drop --force --env=dev
XDEBUG_MODE=off php bin/console doctrine:schema:update --force --env=dev


# Load data
SYMFONY_DEPRECATIONS_HELPER=disabled XDEBUG_MODE=off php bin/console hautelook:fixtures:load --purge-with-truncate --env=dev

# With Mutagen
mutagen-compose --env-file=docker/.env up --config=docker/docker-compose.yaml
