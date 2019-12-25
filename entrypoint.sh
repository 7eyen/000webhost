#!/bin/bash -eu
DEFAULT_ARGS=${ARGS:-''}

git config --global user.email "@"
git config --global user.name "CI" 
git config git-ftp.url $FTP_URL
git config git-ftp.user $FTP_USERNAME
git config git-ftp.password $FTP_PASSWORD

echo 'DEFAULT_ARGS:'$DEFAULT_ARGS

if [[ -n $(git status -s) ]]
then
    git log --oneline
    git add .
    git commit -am 'commit ci runner' -v
    git log --oneline
else
    git ftp push --auto-init $DEFAULT_ARGS
    exit
fi

git ftp push --auto-init $DEFAULT_ARGS

git reset --hard HEAD~
git ftp catchup $DEFAULT_ARGS
