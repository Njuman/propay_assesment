<?php
$app->add($app->getContainer()->get('csrf'));
$app->add(function($request, $response, $next){
	switch ($request->getUri()->getPath()) {
		case '/login':
			break;
		default:
			if(! App\Helper\Acl::isLogged()){
		        return $response->withRedirect('login');
		    }
	}
	$response = $next($request, $response);
	return $response;
});
