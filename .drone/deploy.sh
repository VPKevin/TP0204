#!/bin/bash
set -e
GREEN='1;32'
NC='\033[0m' # No Color

echo {{build.branch}}
echo ${build.branch}
printf "Build ${build.number} of ${build.branch} started. ${build.link}"
printf "${GREEN}Step 1 :${NC} Récupération des anciennes images utilisées\n"
oldImg=$(docker-compose --project-name tp0204 images -q)
printf "${GREEN}Step 2 :${NC} Téléchargement des mise à jours des images\n"
docker-compose --project-name tp0204 pull
printf "${GREEN}Step 3 :${NC} Redémarrage des conteneurs\n"
docker-compose --project-name tp0204 down
docker-compose --project-name tp0204 up -d
printf "${GREEN}Step 4 :${NC} Suppressions des images orphelines\n"
lastImg=$(docker-compose --project-name tp0204 images -q)

for i in $oldImg; do
    skip=0
    for j in $lastImg; do
        [ "$i" = "$j" ] && { skip=1; break; }
    done
    [ $skip = 1 ] || docker rmi "$i" --no-prune
done

#docker-compose --project-name tp0204 down --rmi all

#echo `echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -u` "$Array1" | tr ' ' '\n' | sort | uniq -d
