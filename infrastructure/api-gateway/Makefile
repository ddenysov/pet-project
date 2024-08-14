APP := api_gateway
DC := docker-compose exec

ssh:
	@$(DC) $(APP) bash

start:
	docker-compose up -d --remove-orphans

restart: stop start

stop:
	docker-compose down

build:
	docker-compose build $(APP)
