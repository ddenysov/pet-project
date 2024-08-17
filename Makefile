start: start-iam-service start-infrastructure

stop:  stop-iam-service stop-infrastructure

restart: stop start

start-infrastructure:
	cd ./infrastructure && make start

stop-infrastructure:
	cd ./infrastructure && make stop

start-iam-service:
	cd ./iam-service && make start

stop-iam-service:
	cd ./iam-service && make stop