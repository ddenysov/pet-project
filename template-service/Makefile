APP := template-service-consumer
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
	docker compose restart template-service-scheduler


restart-consumer:
	docker compose restart template-service-consumer


build:
	docker-compose build $(APP)

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

database:
	docker-compose run $(APP) symfony console doctrine:database:create

migration:
	docker-compose run $(APP) symfony console doctrine:migrations:diff

migrate:
	docker-compose run $(APP) symfony console doctrine:migrations:migrate

consume:
	docker-compose run $(APP) symfony console events:consume

setup: install database schema

log:
	docker-compose exec template-service-consumer tail -f ../logs/app.log