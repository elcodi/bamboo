Bamboo Store
============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1940740e-9fe0-498e-8962-024b173a29c0/mini.png)](https://insight.sensiolabs.com/projects/1940740e-9fe0-498e-8962-024b173a29c0)
[![Latest Stable Version](https://poser.pugx.org/elcodi/bamboo-store/v/stable.png)](https://packagist.org/packages/elcodi/bamboo-store)
[![Total Downloads](https://poser.pugx.org/elcodi/bamboo-store/downloads.png)](https://packagist.org/packages/elcodi/bamboo-store)
[![Latest Unstable Version](https://poser.pugx.org/elcodi/bamboo-store/v/unstable.png)](https://packagist.org/packages/elcodi/bamboo-store)
[![License](https://poser.pugx.org/elcodi/elcodi/license.png)](https://packagist.org/packages/elcodi/elcodi)
[![Powered By Elcodi](http://elcodi.io/static/elcodi.badge.png)](http://github.com/elcodi)

Welcome to the Bamboo Store - a fully-functional Ecommerce project
application built on Elcodi components.

As Bamboo Store uses [Composer][2] to manage its dependencies, the recommended
way to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Requirements
------------

The sample application has a few requirements:

* [PHP5.4](http://php.net/releases/5_4_0.php)
* [Imagemagick](http://www.imagemagick.org/) >= 6.X
* [SQLite](http://www.sqlite.org/) >= 3.X

Installation
------------

Use the `create-project` command to generate a new Bamboo Store
application:

```bash
$ php composer.phar create-project elcodi/bamboo-store <path/to/install> dev-master
```

Composer will install Bamboo Store and all its dependencies under the
`path/to/install` directory.


System check
------------

Make sure that your local system is properly configured for Bamboo Store.

Enter the ``path/to/install`` drectory and execute the `check.php` script from the 
command line:

```bash
$ php app/check.php
```    

The script returns a status code of `0` if requirements are met, `1` otherwise.

Schema and Fixtures
-------------------

Create the database and the schema

```bash
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create
```

You can now load the sample data by using the `doctrine:fixture:load` command.
Remember that all Bamboo fixtures are placed in a repository called
[BambooFixtures](https://github.com/elcodi/bamboo-fixtures), so you must
configure the `--fixtures` option with the right path.

```bash
$ php app/console doctrine:fixtures:load --fixtures="vendor/elcodi/bamboo-fixtures"
```

Install the assets
------------------

```bash
$ php app/console assets:install web
$ php app/console assetic:dump
```

Run the application
-------------------

You can run the application using php's built-in web server.

```bash
$ php app/console server:run localhost:8080
```

Point your browser to `http://localhost:8080` and you are done!

Login as a customer
-------------------

You can login as an already registered customer using these credentials.

* email: customer@customer.com
* password: 1234

[1]:  http://symfony.com/doc/2.4/book/installation.html
[2]:  http://getcomposer.org/
