start: start-iam-service start-template-service start-infrastructure

stop:  stop-iam-service stop-template-service stop-infrastructure

restart: stop start

start-infrastructure:
	cd ./infrastructure && make start

stop-infrastructure:
	cd ./infrastructure && make stop

start-iam-service:
	cd ./iam-service && make start

stop-iam-service:
	cd ./iam-service && make stop

start-template-service:
	cd ./template-service && make start

stop-template-service:
	cd ./template-service && make stop