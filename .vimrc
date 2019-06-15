"----------------------
" 基本設定 
"----------------------
"シンタックスハイライト機能をオンにする
syntax enable
"vi互換
set nocompatible
"半角文字の設定
set guifont=MS_Gothic:h20
"全角文字の設定
set guifontwide=MS_Gothic:h20
set belloff=all
" CakePHPのファイルをphpと認識
au BufNewFile,BufRead *.thtml setfiletype php
au BufNewFile,BufRead *.ctp setfiletype php
" 全角スペース可視化
augroup highlightIdegraphicSpace
  autocmd!
  autocmd Colorscheme * highlight IdeographicSpace term=underline ctermbg=DarkGreen guibg=DarkGreen
  autocmd VimEnter,WinEnter * match IdeographicSpace /　/
augroup END
" 前回のカーソル位置を保持
au BufWritePost * mkview
autocmd BufReadPost * loadview
" jsonでダブルクオーテーション表示
"----------------------
" カッコ 
"----------------------
"対応するカッコを強調
set showmatch

"----------------------
" ステータスライン
"----------------------
" ステータス行を常に表示
set laststatus=2
"ファイルナンバー表示
set statusline=[%n]
"ホスト名表示
set statusline+=%{matchstr(hostname(),'\\w\\+')}@
"ファイル名表示
set statusline+=%<%F
"変更のチェック表示
set statusline+=%m
"読み込み専用かどうか表示
set statusline+=%r
"ヘルプページなら[HELP]と表示
set statusline+=%h
"プレビューウインドウなら[Prevew]と表示
set statusline+=%w
"ファイルフォーマット表示
set statusline+=[%{&fileformat}]
set statusline+=[%{&fileencoding}]

"----------------------
" コマンドライン
"----------------------
"コマンドラインモードでtabで補完
set wildmenu wildmode=list:longest,full
"入力中のコマンドを表示
set showcmd

"----------------------
" ウインドウ
"----------------------
if has("gui_running")
  set fuoptions=maxvert,maxhorz
  au GUIEnter * set fullscreen
endif
" 保存されていないファイルがあるときでも別のファイルを開くことが出来る
set hidden
"行番号を表示
set number
" カーソルが何行目の何列目に置かれているかを表示する。（有効:ruler/無効:noruler）
set ruler
" メッセージ表示欄を2行確保
set cmdheight=2
" タイトル表示
set title

" ----------------------
" 検索
" ----------------------
"  大文字小文字を区別しない
set ignorecase
"  大文字で検索ならば大文字限定
set smartcase
" 最後まで検索したら一番上に戻る
set wrapscan
" 検索結果ハイライト
set hlsearch
" インクリメンタルサーチ
set incsearch

" ----------------------
" インデント
" ----------------------
"  自動インデント
set autoindent
set backspace=indent,eol,start

" ----------------------
" クリップボード
" ----------------------
" OSのクリップボードにレジスタ指定なしでyank,putする
set clipboard=unnamed,unnamedplus
" ビジュアルモードで選択した文字がシステムのクリップボードに入る。他のアプリケーションとクリップボードを共有するオプション
set guioptions+=a

" --------------------
" タブ
" --------------------
" タブがスペース何個分か
set tabstop=2
" タブをスペースにする
set expandtab
" 行頭の余白内で tab を打ち込むと、'shiftwidth' の数だけインデントする
set smarttab
" インデントに使われるスペースの数
set shiftwidth=2
" インデントをshiftwidthの数に丸める
set shiftround

" --------------------
" バックアップ
" --------------------
" バックアップしない
set nobackup
" スワップファイルを作らない
set noswapfile
" unファイルを作らない
set noundofile
"viminfoファイルを作らない
set viminfo=

" ------------------------------------------------
" エンコーディング
" ------------------------------------------------
"if &encoding !=# 'utf-8'
"set encoding=japan
"set fileencoding=japan
"endif
"if has('iconv')
"let s:enc_euc = 'euc-jp'
"let s:enc_jis = 'iso-2022-jp'
"" iconvがeucJP-msに対応しているかをチェック
"if iconv("\x87\x64\x87\x6a", 'cp932', 'eucjp-ms') ==# "\xad\xc5\xad\xcb"
"let s:enc_euc = 'eucjp-ms'
"let s:enc_jis = 'iso-2022-jp-3'
"endif
"" fileencodingsを構築
"if &encoding ==# 'utf-8'
"let s:fileencodings_default = &fileencodings
"let &fileencodings = s:enc_jis .','. s:enc_euc .',cp932'
"let &fileencodings = &fileencodings .','. s:fileencodings_default
"unlet s:fileencodings_default
"else
"let &fileencodings = &fileencodings .','. s:enc_jis
"set fileencodings+=utf-8,ucs-2le,ucs-2
"if &encoding =~# '^\(euc-jp\|euc-jisx0213\|eucjp-ms\)$'
"set fileencodings+=cp932
"set fileencodings-=euc-jp
"set fileencodings-=euc-jisx0213
"set fileencodings-=eucjp-ms
"let &encoding = s:enc_euc
"let &fileencoding = s:enc_euc
"else
"let &fileencodings = &fileencodings .','. s:enc_euc
"endif
"endif
"" 定数を処分
"unlet s:enc_euc
"unlet s:enc_jis
"endif
"" 日本語を含まない場合は fileencoding に encoding を使うようにする
"if has('autocmd')
"function! AU_ReCheck_FENC()
"if &fileencoding =~# 'iso-2022-jp' && search("[^\x01-\x7e]", 'n') == 0
"let &fileencoding=&encoding
"endif
"endfunction
"autocmd BufReadPost * call AU_ReCheck_FENC()
"endif
"" 改行コードの自動認識
"set fileformats=unix,dos,mac
"" □とか○の文字があってもカーソル位置がずれないようにする
"if exists('&ambiwidth')
"set ambiwidth=double
"endif
set encoding=utf-8
set fileformat=unix

" --------------------
" キー
" --------------------
set bioskey
set timeout
set timeoutlen=500

" --------------------
" 閉じタグ補完
" --------------------
" 何故か動かない
""augroup MyXML
""  autocmd!
""  autocmd Filetype xml inoremap <buffer> </ </<C-x><C-o>
""  autocmd Filetype html inoremap <buffer> </ </<C-x><C-o>
""augroup END
"=========================================================================
"=========================================================================
"=========================================================================

"//----------------------
"// キーマップ
"//----------------------
inoremap <C-c> <Esc>

" ;と:入れ替え 
nnoremap ;  :
nnoremap :  ;
vnoremap ;  :
vnoremap :  ;

"補完 
inoremap { {}<ESC>i
inoremap ( ()<ESC>i
inoremap [ []<ESC>i
inoremap " ""<ESC>i
inoremap ' ''<ESC>i

" 保存と終了
nnoremap <Space>w  :<C-u>w<CR>
nnoremap <Space>q  :<C-u>q<CR>
nnoremap <Space>Q  :<C-u>q!<CR>

"画面分割
nnoremap s <Nop>
nnoremap ss :<C-u>sp<CR>
nnoremap sv :<C-u>vs<CR>

"分割画面の移動
nnoremap <C-h> <C-w>h
nnoremap <C-j> <C-w>j
nnoremap <C-k> <C-w>k
nnoremap <C-l> <C-w>l
nnoremap sw <C-w>w
nnoremap sJ <C-w>J
nnoremap sK <C-w>K
nnoremap sL <C-w>L
nnoremap sH <C-w>H
nnoremap sr <C-w>r
nnoremap s= <C-w>=
nnoremap so <C-w>_<C-w>|

" 直近の検索ハイライトを消す
nnoremap <C-c> :noh<CR>

""nnoremap <Space>/  *<C-o>
""nnoremap g<Space>/ g*<C-o>

"検索結果送り
nnoremap <expr> n <SID>search_forward_p() ? 'nzv' : 'Nzv'
nnoremap <expr> N <SID>search_forward_p() ? 'Nzv' : 'nzv'
vnoremap <expr> n <SID>search_forward_p() ? 'nzv' : 'Nzv'
vnoremap <expr> N <SID>search_forward_p() ? 'Nzv' : 'nzv'
"スペース + sで検索開始
function! s:search_forward_p()
  return exists('v:searchforward') ? v:searchforward : 1
endfunction
nnoremap <Space>s /

" ファイル内自動インデント
nnoremap == gg=G''

" --------------------
" 移動
" --------------------
" 上下左右
inoremap <C-j> <Down>
inoremap <C-k> <Up>
noremap! <C-h> <Left>
noremap! <C-l> <Right>
noremap! <C-d> <BS>
nnoremap k   gk
nnoremap j   gj
nnoremap gk  k
nnoremap gj  j
vnoremap k   gk
vnoremap j   gj
vnoremap gk  k
vnoremap gj  j

" 矢印キー無効
vnoremap  <Up>     <nop>
vnoremap  <Down>   <nop>
vnoremap  <Left>   <nop>
vnoremap  <Right>  <nop>
inoremap  <Up>     <nop>
inoremap  <Down>   <nop>
inoremap  <Left>   <nop>
inoremap  <Right>  <nop>
noremap   <Up>     <nop>
noremap   <Down>   <nop>
noremap   <Left>   <nop>
noremap   <Right>  <nop>

" 行末行頭
noremap <S-h>   ^
noremap <S-j>   }
noremap <S-k>   {
noremap <S-l>   $

" --------------------
" 行挿入
" --------------------
""nnoremap <Space>o  :<C-u>for i in range(v:count1) \| call append(line('.'), '') \| endfor<CR>
""nnoremap <Space>O  :<C-u>for i in range(v:count1) \| call append(line('.')-1, '') \| endfor<CR>

" --------------------
" 置換
" --------------------
" 全置換
nnoremap gs  :<C-u>%s///g<Left><Left><Left>
" 選択範囲置換
vnoremap gs  :s///g<Left><Left><Left>

" --------------------
" 削除
" --------------------
" ファイル内全削除
nnoremap <Space>da ggVGd
"xでレジスタを汚さない
nnoremap x "_x
vnoremap x "_x
nnoremap X "_X
vnoremap X "_X

" --------------------
" コピー・ヤンク
" --------------------
"  行末までヤンク
nnoremap Y y$
" ヤンクしたあとその選択範囲の末尾に移動
vnoremap <silent> y y`]
" ペーストしたあと貼り付けたものの末尾に移動
vnoremap <silent> p p`]
nnoremap <silent> p p`]

" --------------------
" エンター
" --------------------
inoremap  <C-f> <CR>



"=========================================================================
"=========================================================================
"=========================================================================
"
"//---------------------------
"// 自作関数
"//---------------------------
if filereadable(expand('~/.vim/bin/Randnum.vim'))
    source ~/.vim/bin/Randnum.vim
endif
if filereadable(expand('~/.vim/bin/Randpick.vim'))
    source ~/.vim/bin/Randpick.vim
endif

function! s:get_syn_id(transparent)
  let synid = synID(line("."), col("."), 1)
  if a:transparent
    return synIDtrans(synid)
  else
    return synid
  endif
endfunction
function! s:get_syn_attr(synid)
  let name = synIDattr(a:synid, "name")
  let ctermfg = synIDattr(a:synid, "fg", "cterm")
  let ctermbg = synIDattr(a:synid, "bg", "cterm")
  let guifg = synIDattr(a:synid, "fg", "gui")
  let guibg = synIDattr(a:synid, "bg", "gui")
  return {
        \ "name": name,
        \ "ctermfg": ctermfg,
        \ "ctermbg": ctermbg,
        \ "guifg": guifg,
        \ "guibg": guibg}
endfunction
function! s:get_syn_info()
  let baseSyn = s:get_syn_attr(s:get_syn_id(0))
  echo "name: " . baseSyn.name .
        \ " ctermfg: " . baseSyn.ctermfg .
        \ " ctermbg: " . baseSyn.ctermbg .
        \ " guifg: " . baseSyn.guifg .
        \ " guibg: " . baseSyn.guibg
  let linkedSyn = s:get_syn_attr(s:get_syn_id(1))
  echo "link to"
  echo "name: " . linkedSyn.name .
        \ " ctermfg: " . linkedSyn.ctermfg .
        \ " ctermbg: " . linkedSyn.ctermbg .
        \ " guifg: " . linkedSyn.guifg .
        \ " guibg: " . linkedSyn.guibg
endfunction
command! SyntaxInfo call s:get_syn_info()

"=========================================================================
"=========================================================================
"=========================================================================
"
"//---------------------------
"// NeoBundle
"//---------------------------
" bundleで管理するディレクトリを指定
set runtimepath+=~/.vim/bundle/neobundle.vim/
" Required:
call neobundle#begin(expand('~/.vim/bundle/'))
" neobundle自体をneobundleで管理
NeoBundleFetch 'Shougo/neobundle.vim'

" --------------------
" unite.vim
" --------------------
NeoBundle 'Shougo/unite.vim'
NeoBundle 'Shougo/neomru.vim'
NeoBundle 'Shougo/unite-outline'
"デフォルトで挿入モードからスタート
let g:unite_enable_start_insert=1
" 大文字小文字を区別しない  
let g:unite_enable_ignore_case = 1  
let g:unite_enable_smart_case = 1
"ヒストリーヤンク機能を有効化
let g:unite_source_history_yank_enable = 1
"最近開いたファイルの履歴の数？
let g:unite_source_file_mru_limit = 200
" ESCキーを2回押すと終了する  
au FileType unite nnoremap <silent> <buffer> <C-c> :q<CR>
au FileType unite inoremap <silent> <buffer> <C-c><C-c> <ESC>:q<CR>
"prefix keyの設定
nmap <Space> [unite]

"スペースキーとfキーでカレントディレクトリを表示
nnoremap <silent> [unite]f :<C-u>UniteWithBufferDir -buffer-name=files file<CR>
"スペースキーとfキーでバッファと最近開いたファイル一覧を表示
nnoremap <silent> [unite]b :<C-u>Unite<Space>buffer file_mru<CR>
"スペースキーとdキーで最近開いたディレクトリを表示
nnoremap <silent> [unite]d :<C-u>Unite<Space>directory_mru<CR>
"""スペースキーとbキーでバッファを表示
""nnoremap <silent> [unite]b :<C-u>Unite<Space>buffer<CR>
"スペースキーとrキーでレジストリを表示
nnoremap <silent> [unite]r :<C-u>Unite<Space>register<CR>
"スペースキーとtキーでタブを表示
nnoremap <silent> [unite]t :<C-u>Unite<Space>tab<CR>
"スペースキーとhキーでヒストリ/ヤンクを表示
nnoremap <silent> [unite]h :<C-u>Unite<Space>history/yank<CR>
"スペースキーとoキーでoutline
nnoremap <silent> [unite]o :<C-u>Unite<Space>outline<CR>
"""スペースキーとENTERキーでfile_rec:!
""nnoremap <silent> [unite]<CR> :<C-u>Unite<Space>file_rec:!<CR>
"fzf。カレントディレクトリの取得はuniteの関数を使うため、
"unite.vimがないとだめ
set rtp+=~/.fzf
""let l:current_dir = unite#util#path2project_directory(expand('%'))
nnoremap <silent> [unite]x :call fzf#run({
    \ 'source': 'find . -type f',
    \ 'sink': 'edit',
    \ 'dir': unite#util#path2project_directory(expand('%')),
    \ 'up': 15
    \})<CR>

" --------------------
" カラースキーム
" --------------------
"NeoBundle 'altercation/vim-colors-solarized'
NeoBundle 'tomasr/molokai'
"NeoBundle 'joshdick/onedark.vim'
" カラースキーム一覧表示に Unite.vim を使う
NeoBundle 'ujihisa/unite-colorscheme'

" --------------------
" neocomplete
" --------------------
NeoBundle 'Shougo/neocomplete'

if neobundle#tap('neocomplete')
  call neobundle#config({
  \   'depends': ['Shougo/context_filetype.vim', 'ujihisa/neco-look', 'pocke/neco-gh-issues', 'Shougo/neco-syntax'],
  \ })
  " 起動時に有効化
  let g:neocomplete#enable_at_startup = 1
  " 大文字が入力されるまで大文字小文字の区別を無視する
  let g:neocomplete#enable_smart_case = 1
  " _(アンダースコア)区切りの補完を有効化
  let g:neocomplete#enable_underbar_completion = 1
  let g:neocomplete#enable_camel_case_completion  =  1
  " ポップアップメニューで表示される候補の数
  let g:neocomplete#max_list = 20
  " シンタックスをキャッシュするときの最小文字長
  let g:neocomplete#sources#syntax#min_keyword_length = 3
  " 補完を表示する最小文字数
  let g:neocomplete#auto_completion_start_length = 2
  " preview window を閉じない
  let g:neocomplete#enable_auto_close_preview = 0
  "AutoCmd InsertLeave * silent! pclose!
  let g:neocomplete#max_keyword_width = 10000

  "ココから下は何の設定かよくわからない
  if !exists('g:neocomplete#delimiter_patterns')
    let g:neocomplete#delimiter_patterns= {}
  endif
  let g:neocomplete#delimiter_patterns.ruby = ['::']

  if !exists('g:neocomplete#same_filetypes')
    let g:neocomplete#same_filetypes = {}
  endif
  let g:neocomplete#same_filetypes.ruby = 'eruby'

  if !exists('g:neocomplete#force_omni_input_patterns')
    let g:neocomplete#force_omni_input_patterns = {}
  endif

  let g:neocomplete#force_omni_input_patterns.cpp = '[^.[:digit:] *\t]\%(\.\|->\)\w*\|\h\w*::\w*'
  let g:neocomplete#force_omni_input_patterns.typescript = '[^. \t]\.\%(\h\w*\)\?' " Same as JavaScript
  let g:neocomplete#force_omni_input_patterns.go = '[^. \t]\.\%(\h\w*\)\?'         " Same as JavaScript

  let s:neco_dicts_dir = $HOME . '/dicts'
  if isdirectory(s:neco_dicts_dir)
    let g:neocomplete#sources#dictionary#dictionaries = {
    \   'ruby': s:neco_dicts_dir . '/ruby.dict',
    \   'javascript': s:neco_dicts_dir . '/jquery.dict',
    \ }
  endif
  let g:neocomplete#data_directory = $HOME . '/.vim/cache/neocomplete'

  call neobundle#untap()
endif

" --------------------
" neosnippet
" --------------------
NeoBundle 'Shougo/neosnippet'
NeoBundle 'Shougo/neosnippet-snippets'
"-- ココから下は本家に載っている設定のためとりあえず記述 --"
" Plugin key-mappings.
imap <C-e>     <Plug>(neosnippet_expand_or_jump)
smap <C-e>     <Plug>(neosnippet_expand_or_jump)
xmap <C-e>     <Plug>(neosnippet_expand_target)
" SuperTab like snippets behavior.
imap <expr><TAB> neosnippet#expandable_or_jumpable() ?
\ "\<Plug>(neosnippet_expand_or_jump)"
\: pumvisible() ? "\<C-n>" : "\<TAB>"
smap <expr><TAB> neosnippet#expandable_or_jumpable() ?
\ "\<Plug>(neosnippet_expand_or_jump)"
\: "\<TAB>"
" For snippet_complete marker.
if has('conceal')
  set conceallevel=2 concealcursor=i
endif
"-- 本家ここまで --"

" オリジナルスニペット置き場 
let g:neosnippet#snippets_directory='~/.vim/bundle/neosnippet-snippets/snippets/'

" --------------------
" vim-expand-region
" --------------------
NeoBundle 'terryma/vim-expand-region'
vmap v <Plug>(expand_region_expand)
vmap <C-v> <Plug>(expand_region_shrink)

" --------------------
" emmet
" --------------------
NeoBundle 'mattn/emmet-vim'
let g:user_emmet_leader_key='<Space>e'

" --------------------
" lightline
" --------------------
NeoBundle 'itchyny/lightline.vim'

" --------------------
" vim-indent-line
" --------------------
NeoBundle 'Yggdroot/indentLine'
" Vim
let g:indentLine_color_term = 239
" GVim
let g:indentLine_color_gui = '#A4E57E'
" none X terminal
let g:indentLine_color_tty_light = 7 " (default: 4)
let g:indentLine_color_dark = 1 " (default: 2)
"縦線の文字指定
let g:indentLine_char = '|'

" シングルクオートとダブルクオートの入れ替え等
NeoBundle 'tpope/vim-surround'

" ログファイルを色づけしてくれる
NeoBundle 'vim-scripts/AnsiEsc.vim'

" TypeScript対応
NeoBundle 'leafgarland/typescript-vim'

" 縦整形"
NeoBundle 'junegunn/vim-easy-align'
" Start interactive EasyAlign in visual mode (e.g. vipga)
xmap ga <Plug>(EasyAlign)
" Start interactive EasyAlign for a motion/text object (e.g. gaip)
nmap ga <Plug>(EasyAlign)

" json非表示上書き"
NeoBundle 'elzr/vim-json'
let g:vim_json_syntax_conceal = 0

" solidity シンタックスハイライト
NeoBundle 'tomlion/vim-solidity'

call neobundle#end()

"カラースキームの適用
"何故かココに書かないと適用されない
syntax enable
set background=dark
"colorscheme solarized
autocmd ColorScheme * highlight IncSearch cterm=reverse,bold ctermfg=9
colorscheme molokai

" Required:
filetype plugin indent on
" 未インストールのプラグインがある場合、インストールするかどうかを尋ねてくれるようにする設定
" 毎回聞かれると邪魔な場合もあるので、この設定は任意です。
NeoBundleCheck
