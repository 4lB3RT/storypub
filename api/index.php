<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//fichero con la configuracion de la base de datos
require 'vendor/autoload.php';
require 'config.slim.php';


$app = new \Slim\App(['settings'=>$config]);

    $container['db'] = function ($c) {
        $db = $c['settings']['db'];
        $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],$db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    };

    $app->get('/user',function (Request $request ,Response $response){
       $stmt=$this->db->prepare("SELECT * FROM users");
       $stmt->execute();
       $result =$stmt->fetchAll();
       return $this->response->whitJson($result);
    });

    $app->get('users{id}',function(Request $req,Response $res,$args){
       $id = (int)$args['id'];
    });

    $app->post('/user/add',function (Request $req, Response $res){
       $data=$req->getParsedBody();
       $email = $data['email'];
       $username = $data['username'];
       //$rol = $data['roles'];
       $pass = $data['passwd'];
       $stmt= $this->db->prepare("INSERT INTO users() VALUES(:email,:pass,:username)");
       $stmt->bindParam(':email',$email);
       $stmt->bindParam(':pass',$pass);
       $stmt->bindParam(':username',$username);
       $res->getBody()->write($email);
       return $res;
    });

    $app->run();