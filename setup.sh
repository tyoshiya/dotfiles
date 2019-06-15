#!/bin/bash

#カレント内のドットファイルの中でsetupignore_filesに記載のないもののシンボリックリンクを貼る
for f in .??*
do
    s=true
    while read line
    do
        [[ $f == $line ]] && s=false
    done < setup_ignore_files

    [[ "$s" == false ]] && continue
    if [ ! -e $HOME/$f ]; then
        ln -s $HOME/dotfiles/$f $HOME/$f
        echo "$HOME/dotfiles/$f linked!"
    else
        echo "$HOME/$f: file exists!"
    fi
done
