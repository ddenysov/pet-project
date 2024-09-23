create-network:
	docker network create service_network

create-logs-storage:
	docker volume create --name logs_volume --opt type=none --opt device=./ --opt o=bind

destroy-logs-storage:
	docker volume rm logs_volume

destroy-network:
	docker network rm service_network

start: start-kafka start-api-gateway start-database start-mercure start-minio

stop: stop-kafka stop-api-gateway stop-database stop-minio stop-mercure

start-kafka:
	cd ./kafka && make start

stop-kafka:
	cd ./kafka && make stop

start-mercure:
	cd ./mercure && make start

start-minio:
	cd ./miniio && make start

stop-mercure:
	cd ./mercure && make stop

stop-minio:
	cd ./miniio && make stop

start-api-gateway:
	cd ./api-gateway && make start

stop-api-gateway:
	cd ./api-gateway && make stop

start-database:
	cd ./postgres && make start

stop-database:
	cd ./postgres && make stop

init: create-network create-logs-storage