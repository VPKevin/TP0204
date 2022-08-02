#!/bin/bash
set -e

lastImg=$(docker-compose --project-name tp0204 images -q)
docker-compose --project-name tp0204 pull
docker-compose --project-name tp0204 down
docker-compose --project-name tp0204 up -d
docker rmi $lastImg --no-prune
#docker-compose --project-name tp0204 down --rmi all