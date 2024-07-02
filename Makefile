APP := gateway-service
DC := docker-compose exec
MYSQL := $(DC) -T mysql

start-gateway-service:
	cd gateway-service && docker-compose up -d --remove-orphans

stop-gateway-service:
	cd gateway-service && docker-compose down

start-user-service:
	cd user-service && docker-compose up -d --remove-orphans

stop-user-service:
	cd user-service && docker-compose down

start: start-gateway-service start-user-service

stop: stop-user-service stop-gateway-service