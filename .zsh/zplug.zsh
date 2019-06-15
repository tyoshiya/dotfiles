#install zplug
zplug "zplug/zplug", hook-build:'zplug --self-manage'

#read customize zsh file
zplug "~/.zsh", from:local, use:"<->_*.zsh"

#completions
zplug "zsh-users/zsh-completions"
zplug "zsh-users/zsh-history-substring-search", defer:3
zplug "zsh-users/zsh-syntax-highlighting", defer:2
zplug "glidenote/hub-zsh-completion"
zplug 'Valodim/zsh-curl-completion'
#zplug "b4b4r07/easy-oneliner", if:"which fzf"
#fzf
zplug "junegunn/fzf-bin", \
    as:command, \
    from:gh-r, \
    rename-to:"fzf",\
    frozen:1\

zplug 'b4b4r07/fzf-powertools', \
    as:command, \
    use:'re'

#pece
zplug "peco/peco", \
    as:command, \
    from:gh-r, \
    frozen:1


