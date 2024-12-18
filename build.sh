#!/bin/bash

sudo rm -rf ./vendor/ ./composer.lock

docker container stop devphp;
docker container rm devphp;

docker build . -t devphp:latest

docker run --name=devphp -d -v .:/var/www/html -p 9000:80 devphp

docker exec -it devphp composer install



