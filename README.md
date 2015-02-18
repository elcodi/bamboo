Bamboo e-commerce
=================

Welcome to Bamboo e-commerce - a fully-functional e-commerce application built
using [Elcodi] components on top of the
[Symfony] framework.

Yes, you got it right! Bamboo uses the Symfony framework but our components are
framework agnostic, that is, they only depend on the Symfony components.

Why should I use Symfony?
That's simple, to sell. We provide you with an interface to sell and to manage
your atore. You only have to focus on offering a good product, we take care of
the rest.

Requirements
------------------

### PHP
To use Bamboo and Elcodi you need a PHP version not less than **5.4**

For more info just visit their
[instalation page](http://php.net/manual/en/install.php)

### Redis
Bamboo uses redis to make the app lighter and to minimize the response time.

For more info just visit their
[instalation page](http://redis.io/topics/quickstart)

### Imagick
The images are a really important part of an store. Bamboo uses Imagick to
resize and optimize all the product images

For more info just visit their
[instalation page](http://php.net/manual/en/imagick.setup.php)

> On the installation step you will be asked to provide the Imagick installation
> path. Ensure to configuer the paremeter **imagick_convert_bin_path** right

### MySQL
And, where do you save your data? By default we use MySQL, remember to install
it as well as it's extenson for PHP

For more info just visit their
[instalation page](http://dev.mysql.com/doc/refman/5.1/en/installing.html)

### Composer
[Composer] is required to manage dependencies.

if you have not yet installed Composer, download it following the instructions
on [http://getcomposer.org/](http://getcomposer.org/) or just run the following
command:

```bash
    $ curl -s http://getcomposer.org/installer | php
```

Instalation
------------------

### 1. Install the project

After installing composer you can create your new bamboo project

```bash
    $ php composer.phar create-project elcodi/bamboo path/
```

> The installation process will ask you for some parameters like the database
> driver, username, password, database name, etc

Enter your directory to start the configuration step

```bash
    $ cd path/
```

### 2. Init your database

Now we should create the database to save our data

```bash
    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:create
```

We also load some fixtures to show on our store

```bash
    $ php app/console doctrine:fixtures:load --fixtures="src/Elcodi/Fixtures"
    --no-interaction
```

You can also add the geo information for any country. Just find the two letters
[ISO code](http://en.wikipedia.org/wiki/ISO_3166-1#Current_codes) for the
country you want to load and launch the following command changing ES with your
code

```bash
    $ php app/console elcodi:locations:populate ES
```

> This could take several minutes per country, be patient

### 3. Load and enable the template

Hey, we have some templates for you! Be sure to load 'em all!

```bash
    $ php app/console elcodi:templates:load
    $ php app/console elcodi:templates:enable StoreTemplateBundle
```

### 4. Load the plugins

Bamboo offers a bunch of plugins to customize your store, load it with this
command

```bash
    $ php app/console elcodi:plugins:load
```

### 5. Configure the store

When a store is created it's created "under construction", we can disable that
mode from the command line.

```bash
    $ php app/console elcodi:configuration:set store.under_construction "0"
    $ php app/console elcodi:configuration:set store.name "\"My bamboo store\""
```

> All configurations can be modified from the Admin settings panel

### 6. Run the server

Finally our store is ready to run :)

```bash
   php app/console server:run
```

> You can also [configure a Web server] like Apache or Nginx to run the app like
> all the Symfony apps.

### 7. Visit your store

Yehaaa!! Your store is ready!
This is an environment test so you have some users ready to be used

- **Store:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
    - Customer username: customer@customer.com
    - Customer password: 1234
- **Admin:** [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
    - Admin username: admin@admin.com
    - Admin password: 1234

### 8. Play!

You can now play with the bamboo :)
Don't forget to **create an issue** on
[Bamboo](https://github.com/elcodi/bamboo/issues) or
[Elcodi](https://github.com/elcodi/elcodi/issues) if you found any bug.
Any collaboration is welcome! We look forward to hearing from you!

Issues
------------------

You can report any issue on [Bamboo](https://github.com/elcodi/bamboo/issues) or
[Elcodi](https://github.com/elcodi/elcodi/issues)

Need help
------------------

If you need any help with the instalation or understanding elcodi or bamboo you
can contact us on [gitter](https://gitter.im/elcodi/elcodi).
We will be glad of helping you, just ask for help.


[Composer]: http://getcomposer.org/
[Symfony]: http://symfony.com
[Elcodi]: https://github.com/elcodi/elcodi
[configure a Web server]: http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html
