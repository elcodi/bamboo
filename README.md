Bamboo e-commerce
=================

[![Build Status](https://travis-ci.org/elcodi/bamboo.svg?branch=master)](https://travis-ci.org/elcodi/bamboo)

Welcome to Bamboo e-commerce - a fully-functional e-commerce application built
using [Elcodi] components on top of the
[Symfony] framework.

Yes, you got it right! Bamboo uses the Symfony framework but our components are
framework agnostic, that is, they only depend on the Symfony components as opposed to the whole framework or any of its distributions.

Why should I use Bamboo?
That's simple, to sell your products. We provide you with an interface to sell your products and manage
your store. You only have to focus on offering a good product, we take care of
the rest.

## Requirements

### PHP

To use Bamboo and Elcodi you need a PHP version not less than **5.4**

For more info just visit their
[installation page](http://php.net/manual/en/install.php)

### Redis

Bamboo uses redis to make the app lighter and to minimize the response time.

For more info just visit their
[installation page](http://redis.io/topics/quickstart)

In order to use the last Redis features, like the `HyperLogLog` commands, be
sure your Redis version is at least `v2.8.9`.

Also, don't forget to install the php extension for redis.

### Imagick

Images are a really important part of an store. Bamboo uses Imagick to
resize and optimize all product images

For more info just visit their
[installation page](http://php.net/manual/en/imagick.setup.php)

> On the installation step you will be asked to provide the Imagick installation
> path. Ensure to configure the parameter **imagick_convert_bin_path** right

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

## Installation

### 1. Install the project

After installing composer you can create your new bamboo project. Feel free to
use any version, but we're still creating new features, fixing some issues and
errors, and building our first release, so be sure you are not using master, but
a closed version of the package.

``` bash
$ php composer.phar create-project elcodi/bamboo path/to/your/store/ 0.5.*
```

> The installation process will ask you for some parameters like the database
> driver, username, password, database name, etc

Enter your directory to start the configuration step

``` bash
$ cd path/
```

### 2. Init your database

Now we should create the database and all the application schema. Symfony
provides you an easy way for doing that.

``` bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

We also load some fixtures to show on our store. This fixtures will set your
store in a testing mode, with some categories, some manufacturers and a bunch of
t-shirts. Only for testing purposes :)

``` bash
$ php app/console doctrine:fixtures:load --fixtures="src/Elcodi/Fixtures" --no-interaction
```

These fixtures will not install you any location data, but don't worry, we 
provide you several ways for your location population.

> At the moment, only for Spain and France

We provide you some files with some countries dumped. You will find these files
inside `elcodi/geo-bundle` package, inside the `DataFixtures/ORM/Dumps` folder.
Because location tables are not using foreign keys, you can play with them as
much as you need.

You can also add the geo information for any country. Just find the two letters
[ISO code](http://en.wikipedia.org/wiki/ISO_3166-1#Current_codes) for the
country you want to load and launch the following command changing ES with your
code.

``` bash
$ php app/console elcodi:locations:populate ES
```

> This could take several minutes per country, be patient

### 3. Load the plugins

Bamboo offers a bunch of plugins to customize your store. In the ecosystem of
Bamboo, a Plugin is just a Bundle, so first of all, check that all the plugins
you want to use are actually instantiated in you `AppKernel` class, under `app/`
folder.

To install load these plugins, use this command

``` bash
$ php app/console elcodi:plugins:load
```

The default template is a plugin as well, so you will install it as well with
this command.

### 4. Run the server

Finally our store is ready to run :)

``` bash
$ php app/console server:run
```

> You can also [configure a Web server] like Apache or Nginx to run the app like
> all the Symfony apps.

### 5. Visit your store

Yehaaa! You're done! You're about to see what Elcodi can do for you. A complete
store interface for your customers and some nice features for administrating it.

You can start using these credentials we've already created for you. For the
admin panel use. Remember to remove them properly when your store is on 
production.

``` text
Admin username: admin@admin.com
Admin password: 1234
```

And for the store, use this Customer credentials.

``` text
Customer username: customer@customer.com
Customer password: 1234
```

### 6. Play!

You can now play with the bamboo :)
Don't forget to **create an issue** on
[Bamboo](https://github.com/elcodi/bamboo/issues) or
[Elcodi](https://github.com/elcodi/elcodi/issues) if you found any bug.
Any collaboration is welcome! We look forward to hearing from you!

## Tests

Yes, we are doing some tests, and this will be **in cresciendo**. You can ensure
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
