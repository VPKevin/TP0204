#!/bin/bash
set -e
GREEN='1;32'
NC='\033[0m' # No Color

printf "${GREEN}Step 1 :${NC} Recuperation des anciennes images utilisées\n"
oldImg=$(docker-compose --project-name tp0204 images -q)
#printf "${GREEN}Step 2 :${NC} Mise à jour des images\n"
#docker-compose --project-name tp0204 pull
#printf "${GREEN}Step 3 :${NC} Téléchargement des mises à jour des images\n"
#docker-compose --project-name tp0204 down
#printf "${GREEN}Step 4 :${NC} Démarrage des conteneurs\n"
#docker-compose --project-name tp0204 up -d
printf "${GREEN}Step 5 :${NC} Suppressions des images orphelines\n"
lastImg=$(docker-compose --project-name tp0204 images -q)
#[[ " ${lastImg[*]} " =~ " fby4yk4364d4egr4cdt " ]] && echo "true" || echo "false"
echo "${lastImg[@]}"
#echo [[ "${lastImg[*]}" ]]
#for i in $oldImg ; do
#    if [[ ! " ${lastImg[*]} " =~ " $i " ]]; then
#        printf $i
##        docker rmi $i --no-prune
#    fi
#done

#docker-compose --project-name tp0204 down --rmi all
