build:
	docker compose -f docker-compose.yml -f docker-compose.override.yml up
rebuild-php:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build php
in-php:
	docker exec -it fruits-php-1  /bin/bash
run:
	docker-compose up
