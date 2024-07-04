APP := api-gateway
DC := docker-compose exec

ssh:
	@$(DC) $(APP) bash

start:
	docker-compose up -d --remove-orphans

stop:
	docker-compose down

build:
	docker-compose build $(APP)
