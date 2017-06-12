<?php

// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

//Hash
$container['hash'] = function($c) {
    return new App\Helper\Hash($c->get('app'));
};

// database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($settings['settings']['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container['App\Endpoint\UsersEndpoint'] = function ($c) use ($app) {
    //$settings = $c->get('settings');
    return new App\Endpoint\UsersEndpoint($c->get('view'), $c->get('flash'), $c->get('hash'));
};

$container['App\Endpoint\AuthEndpoint'] = function ($c) use ($app) {
    //$settings = $c->get('settings');
    return new App\Endpoint\AuthEndpoint($c->get('view'), $c->get('flash'), $c->get('hash'),$c->get('auth'));
};
