APP := media-store
DC := docker-compose exec
MYSQL := $(DC) -T mysql

start:
	docker-compose up -d --remove-orphans

stop:
	docker-compose down

restart: stop start

# awqw