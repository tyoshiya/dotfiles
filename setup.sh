#!/bin/sh

source $HOME/dotfiles/.install_zsh.sh

#カレント内のドットファイルの中でsetupignore_filesに記載のないもののシンボリックリンクを貼る
for f in .??*
do
    s=true
    while read line
    do
        [[ $f == $line ]] && s=false
    done < .setupignore

    [[ "$s" == false ]] && continue
    ln -fs $HOME/dotfiles/$f $HOME/$f
    echo "$HOME/dotfiles/$f linked!"
done
