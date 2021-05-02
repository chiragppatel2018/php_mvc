<?php

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once __DIR__.'/vendor/autoload.php';

use App\Core\Application;
use App\Core\Path;

$config = [
    "db" => [
        "type"=>"mysql", // database tyle
        "database"=>"student_management",
        "username"=>"root",
        "password"=>"",
        "host"=>"localhost",
        "port"=>"3306",
    ],
    'GLOBAL_VARIABLE' => [
        "GLOBAL_JS" => ''
    ],
    "site_url" => 'http://127.0.0.1:8080/'
];

$path = new Path();
$app = new Application($path, $config);

$app->router->get('/', 'home');
$app->router->get('/student/login', ["StudentController", "login"]);
$app->router->post('/student/login', ["StudentController", "login"]);
$app->router->get('/students/', ["StudentController", "index"]);
$app->router->get('/student/add', ["StudentController", "Add"]);
$app->router->post('/student/add', ["StudentController", "Add"]);
// $app->router->get('/student/detail/{id}', ["StudentController", "Add"]);
$app->router->get('/student/delete/id', ["StudentController", "Delete"]);

$app->router->get('/contact', 'contact');

$app->run();