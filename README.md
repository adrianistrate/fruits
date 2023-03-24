# First step

Build docker containers

```bash
make build
```

# Second step

Get in container

```bash
make in-php
```

# Third step

While in the container, run:

```bash
symfony console fruits:fetch --env=dev -vvv
```

# CS PHP Fixer

```bash
cd tools/php-cs-fixer/
composer install
cd ../../
PHP_CS_FIXER_IGNORE_ENV=1 tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
```

# Testing

```bash
symfony console doctrine:database:create --env=test
symfony console doctrine:schema:update --force --env=test
php bin/phpunit 
```
