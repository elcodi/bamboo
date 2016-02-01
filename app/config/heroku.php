<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

if (!($stack = getenv('STACK')) || !($stack == 'cedar' || $stack == 'cedar-14')) {
    return;
}

// SendGrid configuration
$sendgridUsername = getenv('SENDGRID_USERNAME');
$sendgridPassword = getenv('SENDGRID_PASSWORD');

if ($sendgridUsername && $sendgridPassword) {
    $container->setParameter('mailer_host', 'smtp.sendgrid.com');
    $container->setParameter('mailer_password', $sendgridPassword);
    $container->setParameter('mailer_port', 25);
    $container->setParameter('mailer_transport', 'smtp');
    $container->setParameter('mailer_user', $sendgridUsername);
}

// ClearDB configuration
$cleardbDatabaseURL = getenv('CLEARDB_DATABASE_URL');

if ($cleardbDatabaseURL && filter_var($cleardbDatabaseURL, FILTER_VALIDATE_URL)) {
    $cleardbDatabase = parse_url($cleardbDatabaseURL);

    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', $cleardbDatabase['host']);
    $container->setParameter('database_name', ltrim($cleardbDatabase['path'], '/'));
    $container->setParameter('database_password', $cleardbDatabase['pass']);
    $container->setParameter('database_port', 3306);
    $container->setParameter('database_user', $cleardbDatabase['user']);
}

// http://symfony.com/doc/current/cookbook/deployment/heroku.html#preparing-your-application
$container->loadFromExtension('monolog', [
    'handlers' => [
        'heroku_logs' => [
            'level' => 'debug',
            'path'  => 'php://stderr',
            'type'  => 'stream',
        ],
    ],
]);
