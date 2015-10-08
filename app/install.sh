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
           cp app/config/parameters.yml.dist app/config/parameters.yml
       fi

       # Firing up composer. Better to invoke the INSTALL than an UPDATE
       sh -c 'composer install --no-interaction --prefer-dist'

       ;;
    h) # help
       echo -e \\n"Usage: $0 [-f]: initializes a Bamboo store"
       echo -e \\n"Use the -f flag to force composer install"

       ;;
esac

# Creating database schema and tables
/usr/bin/env php app/console --no-interaction elcodi:install
