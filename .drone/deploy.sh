#!/bin/bash
set -e

docker-compose --project-name tp0204 down --rmi all
docker-compose --project-name tp0204 up -d