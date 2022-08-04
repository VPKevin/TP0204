#!/bin/bash
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

Array1='key1 key2 key3 key4 key5 key6 key7 key8 key9 key10'
Array2='key1 key2 key3 key4 key5 key6'

Array3=
for i in $Array1; do
    skip=
    for j in $Array2; do
        [ $i == $j ] && { skip=1; break; }
    done
    # shellcheck disable=SC2070
    [ -n $skip ] || echo $i
done
