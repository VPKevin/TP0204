#!/bin/bash
set -e

docker-compose --project-name down --rmi all
docker-compose --file ../docker-compose.yml --project-name TP0204 up -d