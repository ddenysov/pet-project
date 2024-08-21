APP := template-service-supervisor
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
	docker compose restart template-service-supervisor

build:
	docker-compose build $(APP)

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

database:
	docker-compose run $(APP) symfony console doctrine:database:create

migrate:
	docker-compose run $(APP) symfony console doctrine:migrations:migrate