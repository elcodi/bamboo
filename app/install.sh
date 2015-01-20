#!/bin/bash

HOME=$(pwd) sh -c 'composer install --no-interaction'
/usr/bin/php app/console --no-interaction doc:dat:cre
/usr/bin/php app/console --no-interaction doc:sch:cre
/usr/bin/php app/console --no-interaction doc:fix:load --fixtures=vendor/elcodi/bamboo-fixtures/
/usr/bin/php app/console --no-interaction assets:install web --symlink
/usr/bin/php app/console --no-interaction assetic:dump
