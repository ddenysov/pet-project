create-network:
	docker network create service_network

destroy-network:
	docker network rm service_network

start: create-network start-kafka

stop: stop-kafka destroy-network

start-kafka:
	cd ./kafka && docker-compose up -d

stop-kafka:
	cd ./kafka && docker-compose down