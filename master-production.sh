#!/usr/bin/env bash

git pull origin master && ./node_modules/.bin/encore production && /home/footbdbe/bin/php bin/console cache:clear