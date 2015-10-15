# Description
This Docker Compose development environment includes

* PHP 5.6.*
* MySQL 5.6
* Nginx 1.6.2
* Composer

# Usage

First you need to install Docker and Docker Compose.

```bash
cd docker
docker-compose up
```

Now you have a few options to get started

## Basic

Get the ip of the Nginx container.

```
docker inspect $(docker-compose ps -q nginx) | grep IPAddress
```

## Advanced

Run a `dnsdock` container before `docker-compose up`, more info: https://github.com/tonistiigi/dnsdock
Access the containers from the dns records.

# Troubleshooting

## How to enter a container?

Enter the php container to install composer vendors etc.

```bash
docker exec -it $(docker-compose ps -q php) bash
```

## The application is too slow.

Install composer vendors in the container and symlink them to the application directory.
Execute inside the php container:

```bash
mkdir /vendor && ln -sf /vendor ./vendor
```

Using Symfony2 inside Vagrant can be slow due to synchronisation delay incurred by NFS.
You can write the app logs and cache to a folder on the php container.

Enter the php container and create the directory:

```bash
docker exec -it $(docker-compose ps -q php) bash
mkdir /dev/shm/bamboo/
setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX /dev/shm/bamboo/
setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX /dev/shm/bamboo/
```


To view the application logs, run the following commands:

```bash
tail -f /dev/shm/bamboo/app/logs/prod.log
tail -f
```

## No frontcontroller access

You could remove the following lines from `app_dev.php`

```php
if (isset($_SERVER['HTTP_CLIENT_IP'])
    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
    || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1', '113.0.0.1'))
        || php_sapi_name() === 'cli-server')
) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
```
