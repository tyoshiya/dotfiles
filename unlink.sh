#!/bin/bash

#カレント内のドットファイルの中でsetupignore_filesに記載のないもののシンボリックリンクを解除
for f in .??*
do
    s=true
    while read line
    do
        [[ $f == $line ]] && s=false
    done < .setupignore

    [[ "$s" == false ]] && continue
    unlink $HOME/$f
    echo "$HOME/$f unlinked!"
done
