#!/bin/bash

docker-compose -f ./docker/docker-compose.yaml -f ./docker/docker-compose-mac-nfs.yaml down
docker-compose -f ./docker/docker-compose.yaml -f ./docker/docker-compose-mac-nfs.yaml stop
