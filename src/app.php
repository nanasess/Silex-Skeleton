<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use gcrico\SwiftMailerPsrLoggerPlugin\SwiftMailerPsrLoggerPlugin;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new MonologServiceProvider());
$app['monolog.logfile'] = __DIR__.'/../site.log';
$app['monolog.name'] = 'eccube';
$app->register(new SwiftmailerServiceProvider());
$app['swiftmailer.options'] = [
    'transport' => 'smtp',
    'host' => 'localhost',
    'port' => '1025'
];
$app->extend('mailer', function ($mailer) use ($app) {
    $mailer_logger = new SwiftMailerPsrLoggerPlugin($app['monolog']);
    $mailer->registerPlugin($mailer_logger);
    return $mailer;
});
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
}));

return $app;
