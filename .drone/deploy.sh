#!/bin/bash
set -e
GREEN='1;32'
NC='\033[0m' # No Color

ls -la /bin
#printf "${GREEN}Step 1 :${NC} Recuperation des anciennes images utilisées\n"
#oldImg=$(docker-compose --project-name tp0204 images -q)
#printf "${GREEN}Step 2 :${NC} Mise à jour des images\n"
#docker-compose --project-name tp0204 pull
#printf "${GREEN}Step 3 :${NC} Téléchargement des mises à jour des images\n"
#docker-compose --project-name tp0204 down
#printf "${GREEN}Step 4 :${NC} Démarrage des conteneurs\n"
#docker-compose --project-name tp0204 up -d
printf "${GREEN}Step 5 :${NC} Suppressions des images orphelines\n"
echo "$BASH_VERSION"
echo ${GREEN}"testyx"
#lastImg=$(docker-compose --project-name tp0204 images -q)

#echo ${oldImg[@]} ${lastImg[@]} | tr ' ' '\n' | sort | uniq -u
#toDelImg=(`echo ${oldImg[@]} ${lastImg[@]} | tr ' ' '\n' | sort | uniq -u`)
#echo $toDelImg[@]
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

Array1=(key1 key2 key3 key4 key5 key6 key7 key8 key9 key10)
Array2=(key1 key2 key3 key4 key5 key6)

Array3=()
for i in "${Array1[@]}"; do
    skip=
    for j in "${Array2[@]}"; do
        [[ $i == $j ]] && { skip=1; break; }
    done
    [[ -n $skip ]] || Array3+=("$i")
done
declare -p Array3
