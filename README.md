Bamboo e-commerce
=================

[![Build Status](https://travis-ci.org/elcodi/bamboo.svg?branch=master)](https://travis-ci.org/elcodi/bamboo)

> Warning. This project is not tagged as stable yet. During this Beta stage, we
> aim to find and resolve all bugs, empower testing layer and build even a 
> better and bigger project documentation.

Welcome to Bamboo e-commerce - a fully-functional e-commerce application built
using [Elcodi] components on top of the [Symfony] framework.

Yes, you got it right! Bamboo uses the Symfony framework but our components are
framework agnostic, that is, they only depend on the Symfony components as 
opposed to the whole framework or any of its distributions.

Why should I use Bamboo? That's simple, to sell your products. We provide you 
with an interface to sell your products and manage your store. You only have to 
focus on offering a good product, we take care of the rest.

## Requirements

We're trying to build this project with a light default dependencies.

### PHP

To use Bamboo and Elcodi you need a PHP version not less than **5.4**

For more info just visit their
[installation page](http://php.net/manual/en/install.php)

### PHP GD

Images are a really important part of an store. Bamboo uses PHP GD to
resize and optimize all product images

For more info just visit their
[installation page](http://php.net/manual/en/image.installation.php)

> This PHP extension is used to being already installed when you add PHP in your
> distribution

After that, you will be able to change the adapter and use other 
implementations.

### MySQL

And, where do you save your data? By default we use MySQL, remember to install
it as well as its extension for PHP

For more info just visit their
[installation page](http://dev.mysql.com/doc/refman/5.1/en/installing.html)

### Composer

[Composer] is required to manage dependencies.

if you have not yet installed Composer, download it following the instructions
on [http://getcomposer.org/](http://getcomposer.org/) or just run the following
command:

``` bash
$ curl -s http://getcomposer.org/installer | php
```

### Redis

Bamboo uses redis to make the app lighter and to minimize the response time.

For more info just visit their
[installation page](http://redis.io/topics/quickstart)

In order to use the last Redis features, like the `HyperLogLog` commands, be
sure your Redis version is at least `v2.8.9`.

> Make sure to have Redis PHP extension installed.

## Installation

If you're used to working with LAMP environment, then you will have Bamboo 
running in your computer in less than 5 minutes.

### 1. Install the project

After installing composer you can create your new Bamboo project.

``` bash
$ php composer.phar create-project elcodi/bamboo bamboo -sdev
```

> The installation process will ask you for some parameters like the database
> driver, username, password, database name, etc

Enter your directory to start the configuration step and use our magic command
to create a complete development environment. Just one single line to rule them
all

``` bash
$ cd bamboo/
$ php app/console elcodi:install
```

By default only Spain will be installed. We have focused this step to run as 
fast as possible, so then, you'll be able to install more countries. You can add
some countries in addition by using the `--country` command option.

``` bash
$ php app/console elcodi:install --country=france --country=italy
```

### 2. Run the server

Our store is ready to run. Use the built-in server to take a look at the 
project.

``` bash
$ php app/console server:run
```

### 3. Visit your store

You're done! Visit `http://localhost:8000` in your browser and take a look at
what we have for you :) Use these Customer credentials in the store

``` text
Customer username: customer@customer.com
Customer password: 1234
```

And for the admin panel, use this Admin credentials.

``` text
Admin username: admin@admin.com
Admin password: 1234
```

Remember to remove these users properly as soon as you're in production.

## Tests

We are doing some tests, and this will be **in cresciendo**. You can ensure
yourself that all the cases we've been working on are actually green. We are
using Behat and PHPUnit, so you only need to execute all suites by using this
piece of code.

``` bash
$ php bin/behat
$ php bin/phpunit -c app
$ php app/console visithor:go --format=pretty --env=test
```

## Issues

You can report any issue on [Bamboo](https://github.com/elcodi/bamboo/issues) or
[Elcodi](https://github.com/elcodi/elcodi/issues)

## Need help

If you need any help with the installation or understanding elcodi or bamboo you
can contact us on [gitter](https://gitter.im/elcodi/elcodi).
We will be glad to help you, just ask for help.

[Composer]: http://getcomposer.org/
[Symfony]: http://symfony.com
[Elcodi]: https://github.com/elcodi/elcodi
[configure a Web server]: http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
