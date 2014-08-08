Bamboo Admin
============

Welcome to the Bamboo Admin - a fully-functional backend built for Elcodi
components.

As Bamboo Admin uses [Composer][1] to manage its dependencies.

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
$ php composer.phar create-project elcodi/bamboo-admin <path/to/install> dev-master
```

Composer will install Bamboo Admin and all its dependencies under the
`path/to/install` directory.


System check
------------

Make sure that your local system is properly configured for Bamboo Admin.

Enter the `path/to/install` drectory and execute the `check.php` script from the
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
BambooFixtures, so you must configure the `--fixtures` option

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

[1]:  http://getcomposer.org/
