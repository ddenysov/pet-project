APP := gateway-service
DC := docker-compose exec
MYSQL := $(DC) -T mysql

install:
	docker-compose run $(APP) composer install

ssh:
	@$(DC) $(APP) bash

start:
	docker-compose up -d

stop:
	docker-compose down

build:
	docker-compose build $(APP)

schema:
	docker-compose run $(APP) symfony console doctrine:schema:create

jwt-generate:
	docker-compose run $(APP) bin/console lexik:jwt:generate-keypair