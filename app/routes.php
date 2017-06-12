<?php

$app->get('/', 'App\Endpoint\UsersEndpoint:index')->setName('home');
$app->get('/login', 'App\Endpoint\AuthEndpoint:index')->setName('login');
$app->get('/add', 'App\Endpoint\UsersEndpoint:addRender')->setName('addRender');
$app->get('/edit/{id}', 'App\Endpoint\UsersEndpoint:editRender')->setName('editRender');

$app->post('/add', 'App\Endpoint\UsersEndpoint:addAction')->setName('addAction');
$app->post('/edit/{id}', 'App\Endpoint\UsersEndpoint:editAction')->setName('editAction');
$app->post('/login', 'App\Endpoint\AuthEndpoint:loginAction')->setName('loginAction');

$app->post('/delete', 'App\Endpoint\UsersEndpoint:deleteAction')->setName('deleteAction');