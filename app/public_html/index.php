<?php
/**
 * Front Controller: index.php
 *
 *
 */
namespace SblogApp;

require '../Config/init.php';
require VENDOR_DIR . DS . 'autoload.php';
spl_autoload_extensions('.php');
spl_autoload_register(function ($class) {
    $class = str_replace('SblogApp', '', $class);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    include APP_DIR . DS . $class . '.php';
});
/*
$app = new \Slim\Slim(array(
    'templates.path' => TEMPLATES_DIR,
    //'mode' => 'development', // in Config/server_env.php
    'view' => new \Slim\Views\Twig(),
    'log.level' => LOG_LEVEL,
    'log.enabled' => LOG_ENABLED,
    'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(array(
        'path' => LOG_DIR,
        'name_format' => 'y-m-d'
    ))
));
*/

$app = new \SlimController\Slim(array(
    'templates.path'             => TEMPLATES_DIR,
    'controller.class_prefix'    => '\\SblogApp\\Controller',
    'controller.method_suffix'   => '',
    'controller.template_suffix' => 'html',
    'cookies.secret_key' => md5(SECRET_KEY),
    //'view' => new \Slim\Views\Twig(), // just Twig
    'view' => new \Sblog\Lib\View('layout/default.html'), // Twig with Layout
));
//
$app->addRoutes(array(
    '/'            => 'Index:index',
    '/hello/:name' => 'Index:hello',
));
// DEBUG
$app->config('debug', DEBUG);


// Twig by Slim\View
$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => TEMPLATES_CACHE_DIR
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);


$app->run();

// finish
//define('END_TIME', microtime(true));
//$elapsed_time = END_TIME - START_TIME;
//print "Finished\n" . $elapsed_time . " elapsed\n\n";