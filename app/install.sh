#!/bin/bash

# Initialization script for the Bamboo web application

getopts :fh FLAG
case $FLAG in
    f) # force composer install

       # Copies the parameters dist file to the actual parameters.yml.
       # If you run composer manually, you will benefit from Incenteev
       # ParameterHandler, which will interactively ask you for
       # the parameters to be copied.
       if [ ! -e app/config/parameters.yml ]; then
           cp app/config/parameters.dist.yml app/config/parameters.yml
       fi

       # Firing up composer. Better to invoke the INSTALL than an UPDATE
       sh -c 'composer install --no-interaction --prefer-source'

       ;;
    h) # help
       echo -e \\n"Usage: $0 [-f]: initializes a Bamboo store"
       echo -e \\n"Use the -f flag to force composer install"

       ;;
esac

# Creating database schema and tables
/usr/bin/env php app/console --no-interaction doc:dat:cre
/usr/bin/env php app/console --no-interaction doc:sch:cre

/usr/bin/env php app/console --no-interaction doctrine:fixtures:load --fixtures="src/Elcodi/Fixtures"

# Add geographic information by ISO code. Adding "Spain" as a reference
/usr/bin/env php app/console elcodi:locations:populate ES

# Loads elcodi plugins. See Elcodi\Component\Plugin\Services\PluginManager
/usr/bin/env php app/console elcodi:plugins:load

# Enables the store and makes it visible. Also enables the default template
/usr/bin/env php app/console elcodi:configuration:set store.enabled 1
/usr/bin/env php app/console elcodi:configuration:set store.under_construction 0
/usr/bin/env php app/console elcodi:configuration:set store.template "\"StoreTemplateBundle\""

# Assets & Assetic
/usr/bin/env php app/console --no-interaction assets:install web --symlink
/usr/bin/env php app/console --no-interaction assetic:dump
