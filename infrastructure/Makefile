create-network:
	docker network create service_network

destroy-network:
	docker network rm service_network

start: start-kafka

stop: stop-kafka

start-kafka:
	cd ./kafka && docker-compose up -d

stop-kafka:
	cd ./kafka && docker-compose down

init: create-network