APP := ride-service-consumer
DC := docker-compose exec
MYSQL := $(DC) -T mysql

install:
	docker-compose run $(APP) composer install

ssh:
	@$(DC) $(APP) bash

start:
	docker-compose up -d --remove-orphans

stop:
	docker-compose down

restart: stop start

reload: restart-consumer restart-scheduler

restart-scheduler:
	docker compose restart ride-service-scheduler

restart-consumer:
	docker compose restart ride-service-consumer


build:
	docker-compose build $(APP)

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

database:
	docker-compose run $(APP) symfony console doctrine:database:create

migrate:
	docker-compose run $(APP) symfony console doctrine:migrations:migrate

consume:
	docker-compose run $(APP) symfony console events:consume

setup: install database schema