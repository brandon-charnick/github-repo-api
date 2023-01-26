up:
	docker compose up -d

build:
	docker compose build database \
	&& docker compose build php \
	&& docker compose build nginx

php:
	docker exec -it php /bin/bash