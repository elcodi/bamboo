Bamboo Admin
============

Welcome to the Bamboo Admin - a fully-functional backend built for Elcodi components.

As Bamboo Admin uses [Composer][1] to manage its dependencies.

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

1) Install the project using git
-------------------------------------

Use the `git clone` command to generate a new Bamboo Admin
application:

```bash
$ git clone git@github.com:elcodi/bamboo-admin.git <path/to/install>
```

2) Install project dependencies
-------------------------------------

Install all project dependencies via composer. Change to ``path/to/install`` directory and execute the following command:

```bash
$ php composer.phar install
``` 

3) Check your System Configuration
-------------------------------------

Make sure that your local system is properly configured for Bamboo Admin.

Execute the `check.php` script from the command line:

```bash
$ php app/check.php
```    

The script returns a status code of `0` if requirements are met, `1` otherwise.

4) Generate schema and load fixtures
-------------------

First af all, create a `parameters.yml` file and change the parameters according to your settings.

```bash
$ cp app/config/parameters.yml.dist app/config/parameters.yml
```

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


[1]:  http://getcomposer.org/
