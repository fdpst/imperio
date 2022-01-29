<?php

define('LARAVEL_START', microtime(true));

require __DIR__.'/laravelcore/vendor/autoload.php';

$app = require_once __DIR__.'/laravelcore/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$app->bind('path.public', function (){
	return base_path() . '/..';
});

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
