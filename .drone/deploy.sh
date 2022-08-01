#!/bin/bash
set -e

#pwd
#ls -la
ls -la /var/run
cat /var/run/docker.sock
docker-compose --project-name TP0204 down --rmi all
docker-compose --project-name TP0204 up -d