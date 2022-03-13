#!/bin/bash

docker-compose -f ./docker/docker-compose.yml -f ./docker/docker-compose-mac-nfs.yml down
docker-compose -f ./docker/docker-compose.yml -f ./docker/docker-compose-mac-nfs.yml stop
