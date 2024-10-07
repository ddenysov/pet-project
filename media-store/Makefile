APP := media-store-fpm
DC := docker-compose exec

start:
	docker-compose up -d --remove-orphans

stop:
	docker-compose down

restart: stop start

ssh:
	@$(DC) $(APP) bash

# awqw