#!/usr/bin/env bash

mkdir -p /etc/puppet/modules

puppet module install puppetlabs-apache
puppet module install puppetlabs-mysql
puppet module install nodes/php
