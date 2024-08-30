APP := npm
DC :=

install:
	docker-compose run $(APP) composer install

ssh:
	@$(DC) $(APP) bash

run:
	@$(DC) $(APP) run dev
