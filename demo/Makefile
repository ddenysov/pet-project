APP := app
DC := docker compose exec

start:
	docker compose up -d --remove-orphans

stop:
	docker compose down

restart: stop start

ssh:
	@$(DC) $(APP) sh

# awqw