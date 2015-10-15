<?php
require 'vendor/Slim/Slim.php';
require 'vendor/RedBean/rb.php';
require 'vendor/Slim/Http/baseController.php';
require 'vendor/Slim/Http/auth.php';

use Slim\Slim;

R::setup( 'mysql:host=localhost;dbname=website',
    'root', '' );

Slim::registerAutoloader();

$app = new Slim();

$app->config(array(
    'templates.path' => 'client'
));

$app->get('/', function() use ($app) {
    $app->render('index.html');
});

$app->post('/createUser', function(){
    baseController::call('userController@createUser');
});

$app->post('/connectionUser', function(){
    baseController::call('userController@connectionUser');
});



$app->run();
