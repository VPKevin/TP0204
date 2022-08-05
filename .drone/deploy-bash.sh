#!/bin/bash
set -e
GREEN='1;32'
NC='\033[0m' # No Color

dockerName=$DRONE_REPO_NAME'_'$DRONE_COMMIT_BRANCH

printf "Build $dockerName"
printf "${GREEN}Step 1 :${NC} Récupération des anciennes images utilisées\n"
oldImg=$(docker-compose --project-name $dockerName images -q)
printf "${GREEN}Step 2 :${NC} Téléchargement des mise à jours des images\n"
docker-compose --project-name $dockerName pull
printf "${GREEN}Step 3 :${NC} Redémarrage des conteneurs\n"
docker-compose --project-name $dockerName down
docker-compose --project-name $dockerName up -d
printf "${GREEN}Step 4 :${NC} Suppressions des images orphelines\n"
lastImg=$(docker-compose --project-name $dockerName images -q)

for i in $oldImg; do # Ne supprime que les images de oldImg non présentes dans lastImg
    skip=0
    for j in $lastImg; do
        [ "$i" = "$j" ] && { skip=1; break; }
    done
    [ $skip = 1 ] || docker rmi "$i" --no-prune
done

#docker-compose --project-name tp0204 down --rmi all

#echo `echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -u` "$Array1" | tr ' ' '\n' | sort | uniq -d
