#!/bin/sh

#zshがインストールされているか確認してインストールされていなければインストールする
if [ `cat /etc/shells | grep "zsh" | wc -c` -eq 0 ] ;
then
 sudo yum -y install zsh
 chsh -s /bin/zsh
fi

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
