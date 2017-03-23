<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

    $app = new \Slim\App;

    $app->get('/hello/{name}', 'hello');

    $app->run();

function hello($name=null,Request $request ,Response $response){
    $name=$argc['name'];
    if($name != null){
        $response->getBody()->write($name);
    }else{
        $response->getBody()->write($name);
    }
    return $response;
}