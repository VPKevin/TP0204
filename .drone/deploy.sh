#!/bin/bash
set -e

pwd
docker-compose --project-name down --rmi all
docker-compose --file /drone/src/docker-compose.yml --project-name TP0204 up -d