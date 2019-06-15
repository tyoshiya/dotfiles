#コマンドがあるか判定する関数だが何に使うのかよくわからない
has() {
    type "${1:?too few arguments}" &>/dev/null
}
is_exists() { type "$1" >/dev/null 2>&1; return $?; }

# reload resets Completion function
reload() {
    local f
    f=(~/.zsh/Completion/*(.))
    unfunction $f:t 2>/dev/null
    autoload -U $f:t
}

# is_login_shell returns true if current shell is first shell
is_login_shell() {
    [[ $SHLVL == 1 ]]
}

# is_git_repo returns true if cwd is in git repository
is_git_repo() {
    git rev-parse --is-inside-work-tree &>/dev/null
    return $status
}

# is_screen_running returns true if GNU screen is running
is_screen_running() {
    [[ -n $STY ]]
}

# is_tmux_runnning returns true if tmux is running
is_tmux_runnning() {
    [[ -n $TMUX ]]
}

# is_screen_or_tmux_running returns true if GNU screen or tmux is running
is_screen_or_tmux_running() {
    is_screen_running || is_tmux_runnning
}

# shell_has_started_interactively returns true if the current shell is
# running from command line
shell_has_started_interactively() {
    [[ -n $PS1 ]]
}

# is_ssh_running returns true if the ssh deamon is available
is_ssh_running() {
    [[ -n $SSH_CLIENT ]]
}

# ostype returns the lowercase OS name
ostype() {
    echo ${(L):-$(uname)}
}

# os_detect export the PLATFORM variable as you see fit
os_detect() {
    export PLATFORM
    case "$(ostype)" in
        *'linux'*)  PLATFORM='linux'   ;;
        *'darwin'*) PLATFORM='osx'     ;;
        *'bsd'*)    PLATFORM='bsd'     ;;
        *)          PLATFORM='unknown' ;;
    esac
}

# is_osx returns true if running OS is Macintosh
is_osx() {
    os_detect
    if [[ $PLATFORM == "osx" ]]; then
        return 0
    else
        return 1
    fi
}
alias is_mac=is_osx

# is_linux returns true if running OS is GNU/Linux
is_linux() {
    os_detect
    if [[ $PLATFORM == "linux" ]]; then
        return 0
    else
        return 1
    fi
}

# is_bsd returns true if running OS is FreeBSD
is_bsd() {
    os_detect
    if [[ $PLATFORM == "bsd" ]]; then
        return 0
    else
        return 1
    fi
}

# get_os returns OS name of the platform that is running
get_os() {
    local os
    for os in osx linux bsd; do
        if is_$os; then
            echo $os
        fi
    done
}

# Surround a forward word by double quote
quote-previous-word-in-double() {
    modify-current-argument '${(qqq)${(Q)ARG}}'
    zle vi-forward-blank-word
}

# Surround a forward word by single quote
quote-previous-word-in-single() {
    modify-current-argument '${(qq)${(Q)ARG}}'
    zle vi-forward-blank-word
}

#pwdをコピー
pwdc(){
    current=`pwd`
    if [ ! ${1} = "" ]; then
        current="${current}/${1}"
    fi
    echo "${current}" | tr -d '\n' | pbcopy
}
##################################################
###
### fzf
###
##################################################
fe() {
  local file
  file=$(fzf --query="$1" --select-1 --exit-0)
  [ -n "$file" ] && /Applications/MacVim.app/Contents/MacOS/Vim "$file"
}
#ディレクトリ検索
fd() {
  local dir
  dir=$(find ${1:-*} -path '*/\.*' -prune \
                  -o -type d -print 2> /dev/null | fzf +m) &&
  cd "$dir" && ls -GF
}

#履歴検索はCtrl+rでやるためこの関数は不要
## fh - repeat history
##履歴検索
#fh() {
#  eval $(([ -n "$ZSH_NAME" ] && fc -l 1 || history) | fzf +s | sed 's/ *[0-9]* *//')
#}

fzf-select-history() {
    if true; then
        BUFFER="$(
        history 1 \
            | sort -k1,1nr \
            | perl -ne 'BEGIN { my @lines = (); } s/^\s*\d+\s*//; $in=$_; if (!(grep {$in eq $_} @lines)) { push(@lines, $in); print $in; }' \
            | fzf --query "$LBUFFER"
        )"

        CURSOR=$#BUFFER
        #zle accept-line
        #zle clear-screen
        zle reset-prompt
    else
        if is-at-least 4.3.9; then
            zle -la history-incremental-pattern-search-backward && bindkey "^r" history-incremental-pattern-search-backward
        else
            history-incremental-search-backward
        fi
    fi
}

##################################################
###
### tmux
###
##################################################
function tmux_automatically_attach_session()
{
    if is_screen_or_tmux_running; then
        ! is_exists 'tmux' && return 1

        if is_tmux_runnning; then
            echo "${fg_bold[red]} _____ __  __ _   ___  __ ${reset_color}"
            echo "${fg_bold[red]}|_   _|  \/  | | | \ \/ / ${reset_color}"
            echo "${fg_bold[red]}  | | | |\/| | | | |\  /  ${reset_color}"
            echo "${fg_bold[red]}  | | | |  | | |_| |/  \  ${reset_color}"
            echo "${fg_bold[red]}  |_| |_|  |_|\___//_/\_\ ${reset_color}"
        elif is_screen_running; then
            echo "This is on screen."
        fi
    else
        if shell_has_started_interactively && ! is_ssh_running; then
            if ! is_exists 'tmux'; then
                echo 'Error: tmux command not found' 2>&1
                return 1
            fi

            if tmux has-session >/dev/null 2>&1 && tmux list-sessions | grep -qE '.*]$'; then
                # detached session exists
                tmux list-sessions
                echo -n "Tmux: attach? (y/N/num) "
                read
                if [[ "$REPLY" =~ ^[Yy]$ ]] || [[ "$REPLY" == '' ]]; then
                    tmux attach-session
                    if [ $? -eq 0 ]; then
                        echo "$(tmux -V) attached session"
                        return 0
                    fi
                elif [[ "$REPLY" =~ ^[0-9]+$ ]]; then
                    tmux attach -t "$REPLY"
                    if [ $? -eq 0 ]; then
                        echo "$(tmux -V) attached session"
                        return 0
                    fi
                fi
            fi

            if is_osx && is_exists 'reattach-to-user-namespace'; then
                # on OS X force tmux's default command
                # to spawn a shell in the user's namespace
                tmux_config=$(cat $HOME/.tmux.conf <(echo 'set-option -g default-command "reattach-to-user-namespace -l $SHELL"'))
                tmux -f <(echo "$tmux_config") new-session && echo "$(tmux -V) created new session supported OS X"
            else
                tmux new-session && echo "tmux created new session"
            fi
        fi
    fi
}


function _gomi() {
    return $1
}

_gomi "$@"






##################################################
###
### 何の関数かわからない系
###
##################################################
#何の関数かわからない
#do-enter() {
#    if [[ -n $BUFFER ]]; then
#        zle accept-line
#        return $status
#    fi
#
#    : ${ls_done:=false}
#    : ${git_ls_done:=false}
#
#    if [[ $PWD != $GIT_OLDPWD ]]; then
#        git_ls_done=false
#    fi
#
#    echo
#    if is_git_repo; then
#        if $git_ls_done; then
#            if [[ -n $(git status --short) ]]; then
#                git status
#            fi
#        else
#            ${=aliases[ls]} && git_ls_done=true
#            GIT_OLDPWD=$PWD
#        fi
#    else
#        if [[ $PWD != $OLDPWD ]] && ! $ls_done; then
#            ${=aliases[ls]} && ls_done=true
#        fi
#    fi
#
#    zle reset-prompt
#}
#zle -N do-enter
#bindkey '^m' do-enter
#
## 何の関数かわからない
#_delete-char-or-list-expand() {
#    if [ -z "$RBUFFER" ]; then
#        zle list-expand
#    else
#        zle delete-char
#    fi
#}
#zle -N _delete-char-or-list-expand
#bindkey '^D' _delete-char-or-list-expand
#
#git add をなんちゃら系？
#peco-select-gitadd() {
#    local selected_file_to_add
#    selected_file_to_add="$(
#    git status --porcelain \
#        | perl -pe 's/^( ?.{1,2} )(.*)$/\033[31m$1\033[m$2/' \
#        | fzf --ansi --exit-0 \
#        | awk -F ' ' '{print $NF}' \
#        | tr "\n" " "
#    )"
#
#    if [ -n "$selected_file_to_add" ]; then
#        BUFFER="git add $selected_file_to_add"
#        CURSOR=$#BUFFER
#        zle accept-line
#    fi
#    zle reset-prompt
#}
#zle -N peco-select-gitadd
#bindkey '^g^a' peco-select-gitadd
#
#よくわからない（消しても違いがわからなかった)
## expand global aliases by space
## http://blog.patshead.com/2012/11/automatically-expaning-zsh-global-aliases---simplified.html
#globalias() {
#  if [[ $LBUFFER =~ ' [A-Z0-9]+$' ]]; then
#    zle _expand_alias
#    # zle expand-word
#  fi
#  zle self-insert
#}
#
#zle -N globalias
#bindkey " " globalias
