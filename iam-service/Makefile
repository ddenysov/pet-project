APP := iam-service-consumer
DC := docker-compose exec
MYSQL := $(DC) -T mysql

install:
	docker-compose run $(APP) composer install

ssh:
	@$(DC) $(APP) bash

log:
	docker-compose exec iam-service-consumer tail -f ../logs/app.log

start:
	docker-compose up -d --remove-orphans

stop:
	docker-compose down

reload: restart-consumer restart-scheduler

restart-scheduler:
	docker compose restart iam-service-scheduler

restart-consumer:
	docker compose restart iam-service-consumer

restart: stop start

restart-sv:
	docker compose restart iam-service-supervisor

build:
	docker-compose build $(APP)

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

jwt-generate:
	docker-compose run $(APP) bin/console lexik:jwt:generate-keypair

migration:
	docker-compose run $(APP) symfony console doctrine:migrations:diff

migrate:
	docker-compose run $(APP) symfony console doctrine:migrations:migrate