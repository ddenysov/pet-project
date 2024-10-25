start: start-iam-service start-template-service start-ride-service start-track-service start-media-store start-infrastructure

stop:  stop-iam-service stop-template-service stop-ride-service stop-track-service stop-media-store stop-infrastructure

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

start-ride-service:
	cd ./ride-service && make start

stop-ride-service:
	cd ./ride-service && make stop

start-track-service:
	cd ./track-service && make start

stop-track-service:
	cd ./track-service && make stop


start-media-store:
	cd ./media-store && make start

stop-media-store:
	cd ./media-store && make stop
