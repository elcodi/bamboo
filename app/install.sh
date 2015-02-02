#!/bin/bash

# Copies the parameters dist file to the actual parameters.yml.
# If you run composer manually, you will benefit from Incenteev
# ParameterHandler, which will interactively ask you for
# the parameters to be copied.
if [ ! -e app/config/parameters.yml ]; then
    cp app/config/parameters.dist.yml app/config/parameters.yml
fi

# Firing up composer. Better to invoke the INSTALL than an UPDATE
HOME=$(pwd) sh -c 'composer install --no-interaction'

# Creating database schema and tables
/usr/bin/php app/console --no-interaction doc:dat:cre
/usr/bin/php app/console --no-interaction doc:sch:cre

# Allowed fixtures go here
FIXTURES="AdminUser Category Country Currency Manufacturer Page Rates Attribute \
          Configuration Coupon Customer Language Menu Product Tax"

for FIXTURE in ${FIXTURES}; do
     FIXTURES_OPTION="${FIXTURES_OPTION} --fixtures=src/Elcodi/Fixtures/DataFixtures/ORM/${FIXTURE}"
done
/usr/bin/php app/console --no-interaction doc:fix:load ${FIXTURES_OPTION}

# Load and enable templates. See Elcodi\Component\Template\Services\TemplateManager
/usr/bin/php app/console el:tem:lo
/usr/bin/php app/console el:tem:enable StoreTemplateBundle

# Loads elcodi plugins. See Elcodi\Component\Plugin\Services\PluginManager
/usr/bin/php app/console el:plu:lo

# Enables the store and makes it visible
/usr/bin/php app/console el:con:set store.enabled 1
/usr/bin/php app/console el:con:set store.under_construction 0

# Assets & Assetic
/usr/bin/php app/console --no-interaction assets:install web --symlink
/usr/bin/php app/console --no-interaction assetic:dump
