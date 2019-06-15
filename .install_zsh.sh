#zshがインストールされているか確認してインストールされていなければインストールする
if [ `cat /etc/shells | grep "zsh" | wc -c` -eq 0 ] ;
then
 sudo yum -y install zsh
 chsh -s /bin/zsh
fi
