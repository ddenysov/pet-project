create-network:
	docker network create service_network

destroy-network:
	docker network rm service_network

start: start-kafka start-api-gateway start-database

stop: stop-kafka stop-api-gateway stop-database

start-kafka:
	cd ./kafka && make start

stop-kafka:
	cd ./kafka && make stop

start-api-gateway:
	cd ./api-gateway && make start

stop-api-gateway:
	cd ./api-gateway && make stop

start-database:
	cd ./postgres && make start

stop-database:
	cd ./postgres && make stop

init: create-network