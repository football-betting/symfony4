#!/usr/bin/env bash

git pull origin master && ./node_modules/.bin/encore production && /usr/local/pd-admin2/bin/php-7.2-cli bin/console cache:clear