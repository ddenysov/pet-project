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

restart-sv:
	docker compose restart template-service-consumer && docker compose restart template-service-scheduler

build:
	docker-compose build $(APP)

consume:
	docker-compose run $(APP) symfony console events:consume

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

database:
	docker-compose run $(APP) symfony console doctrine:database:create

migrate:
	docker-compose run $(APP) symfony console doctrine:migrations:migrate