#!/bin/ash
set -e
GREEN='1;32'
NC='\033[0m' # No Color

ps  -ef | grep $$ | grep -v grep
echo $0
echo $BASH
#ls -la /bin
echo $BASH_VERSION
echo "$BASH_VERSION"
# shellcheck disable=SC2086
echo $BASH_VERSION
echo ${GREEN}"testyx"

Array1='key1 key2 key4 key6 key7 key8 key9 key10'
Array2='key1 key3 key4 key5 key6'
echo $Array1
echo "$Array1"
Array3=
for i in $Array1; do
    skip=0
    for j in $Array2; do
        [ $i == $j ] && { skip=1; break; }
    done
    [ $skip = 1 ] || echo $i
done
#ArrayEnd={ echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -u };
#echo $ArrayEnd
echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -u
echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -d
echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -u | uniq
echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -d | uniq

#ArrayEnd=`echo "$Array1" "$Array2" | tr ' ' '\n' | sort | uniq -d | uniq`
#echo $ArrayEnd