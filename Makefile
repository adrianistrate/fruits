build:
	docker compose -f docker-compose.yml -f docker-compose.override.yml build --no-cache
rebuild-php:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build php
rebuild-db:
	docker-compose -f docker-compose.yml build database
in-php:
	docker exec -it fruits-php-1  /bin/bash
run:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml up
