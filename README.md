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
------------------

The sample application has a few requirements:

* [Imagemagick](http://www.imagemagick.org/) >= 6.X
* [SQLite](http://www.sqlite.org/) >= 3.X

1) Install the project using composer
-------------------------------------

Use the `create-project` command to generate a new Bamboo Store
application:

```bash
$ php composer.phar create-project elcodi/bamboo-store <path/to/install> dev-master
```

Composer will install Bamboo Store and all its dependencies under the
`path/to/install` directory.


2) Check your System Configuration
-------------------------------------

Make sure that your local system is properly configured for Bamboo Store.

Enter the ``path/to/install`` drectory and execute the `check.php` script from the 
command line:

```bash
$ php app/check.php
```    

The script returns a status code of `0` if requirements are met, `1` otherwise.

3) Generate schema and load fixtures
-------------------

Create the database and the schema

```bash
$ php app/console doctrine:database:create && php app/console doctrine:schema:create
```

You can now load the sample data by using the ``doctrine:fixture:load`` command:

```bash
$ php app/console doctrine:fixture:load --fixtures=src
```

4) Install the assets
---------------------

```bash
$ php app/console assets:install web && php app/console assetic:dump
```

5) Run the application using php's built-in web server
------------------------------------------------------

```bash
$ php app/console server:run 0.0.0.0:8080
```

Point your browser to ``http://localhost:8080`` and you are done!


[1]:  http://symfony.com/doc/2.4/book/installation.html
[2]:  http://getcomposer.org/
