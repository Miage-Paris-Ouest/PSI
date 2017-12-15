<?php

date_default_timezone_set('Europe/Paris');

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new GestionnaireLivret\DAO\UserDAO($app['db']);
            },
        ),
    ),
));


// Register services
$app['dao.diplome'] = function ($app) {
    return new GestionnaireLivret\DAO\DiplomeDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new GestionnaireLivret\DAO\UserDAO($app['db']);
};

$app['dao.cours'] = function ($app) {
    return new GestionnaireLivret\DAO\CoursDAO($app['db']);
};
