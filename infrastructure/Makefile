create-network:
	docker network create service_network

destroy-network:
	docker network rm service_network

start: start-kafka start-api-gateway

stop: stop-kafka stop-api-gateway

start-kafka:
	cd ./kafka && make start

stop-kafka:
	cd ./kafka && make stop

start-api-gateway:
	cd ./api-gateway && make start

stop-api-gateway:
	cd ./api-gateway && make stop

init: create-network