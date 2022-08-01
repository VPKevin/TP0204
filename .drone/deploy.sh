#!/bin/bash
set -e

#pwd
#ls -la

docker-compose --project-name TP0204 down --rmi all
docker-compose --project-name TP0204 up -d