<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . './../vendor/autoload.php';

$app = new ShadowFiend\Core\Application\Application(__DIR__ . './../App');

$app->setRouter(new ShadowFiend\Core\Router\Router('App\\Controllers'));

$app->setDebuggable();

$db = new Capsule();
$db->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => $_ENV['database'],
    'username' => $_ENV['db_username'],
    'password' => $_ENV['db_password'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$db->setAsGlobal();
$db->bootEloquent();

$app->get('/', 'MainController_Index');
$app->get('/jobs/create', 'JobsController_createform');
$app->post('/jobs/create', 'JobsController_create');
$app->get('/jobs/change', 'JobsController_changeform');
$app->post('/jobs/change', 'JobsController_change');
$app->post('/auth/login', 'AuthController_login');
$app->get('/auth/register', 'AuthController_regform');
$app->post('/auth/register', 'AuthController_register');
$app->get('/auth/logout', 'AuthController_logout');


$app->get('/setup', 'SetupController_index');

$app->run();
