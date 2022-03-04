## WORK IN PROGRESS


$ make

Usage:
  make <target>

[Docker] Build / Infrastructure
1.  docker-clean                 Remove the .env file for docker
2.  docker-init                  Make sure the .env file exists for docker
3.  docker-build-from-scratch    Build all docker images from scratch, without cache etc. Build a specific image by providing the service name via: make docker-build CONTAINER=<service>
  docker-test                  Run the infrastructure tests for the docker setup
  docker-build     (rebuild)   Build all docker images. Build a specific image by providing the service name via: make docker-build CONTAINER=<service>
  docker-prune                 Remove unused docker resources via 'docker system prune -a -f --volumes'
  docker-up                    Start all docker containers. To only start one container, use CONTAINER=<service>
  docker-down                  Stop all docker containers. To only stop one container, use CONTAINER=<service>
  docker-config                Show the docker-compose config with resolved .env values

[Application]
5.  composer                     Run composer and provide the command via ARGS="command --options"
6.  artisan                      Run artisan and provide the command via ARGS="command --options"
4.  composer-install             Run composer install


Note: dB file is contain in the root dir (glide.sql)

Run the project in -> http://localhost/

