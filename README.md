# Football Betting

[![Build Status](https://travis-ci.com/football-betting/symfony4.svg?branch=master)](https://travis-ci.com/football-betting/symfony4)


## Setup

1. set a new `127.0.0.1 symfony.dev.nxs` host-entry
2. run `docker-compose up -d` in project root
3. setup the ssh connection
4. upload the `symfony4` folder to `/var/www/`
5. go to `/var/www/` and create symlink `ln -s symfony4/public symfony`
5. ssh into the container and run `composer install` in `/var/www/symfony4/`


## scss / js changes

all files will be compiled after `composer install` has been executed.
If you want the rebuild the frontend files manually just run `yarn run encore dev` in the project root

## Credentials

**MYSQL**

Docker-User
Host: 127.0.0.1 (Docker-Host)
Port: 3336
User: docker
Pass: docker

**SSH**

Docker-User
Host: 127.0.0.1 (Docker-Host)
Port: 2222
User: docker
Pass: docker