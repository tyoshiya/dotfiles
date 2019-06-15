#!/bin/sh

#zshがインストールされているか確認してインストールされていなければインストールする
RESULT=`zsh --version`
echo $RESULT
if [[ $RESULT == *command not found* ]]; then echo 'FOUND!!!'; fi

##カレント内のドットファイルの中でsetupignore_filesに記載のないもののシンボリックリンクを貼る
#for f in .??*
#do
#    s=true
#    while read line
#    do
#        [[ $f == $line ]] && s=false
#    done < setup_ignore_files
#
#    [[ "$s" == false ]] && continue
#    ln -fs $HOME/dotfiles/$f $HOME/$f
#    echo "$HOME/dotfiles/$f linked!"
#done
