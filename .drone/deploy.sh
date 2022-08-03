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

toDelImg=(`echo ${oldImg[@]} ${lastImg[@]} | tr ' ' '\n' | sort | uniq -u `)
echo ${toDelImg[@]}
#for i in ${toDelImg} ; do
#    docker rmi $i --no-prune
#done

#for o in $oldImg ; do
#  for l in $lastImg ; do
#    [[ " $l " == " $o " ]] && docker rmi $o --no-prune
#  done
##    if [[ ! " ${lastImg[*]} " =~ " $i " ]]; then
##        printf $i
###        docker rmi $i --no-prune
##    fi
#done

#docker-compose --project-name tp0204 down --rmi all
