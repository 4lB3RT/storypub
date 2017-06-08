<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'config.slim.php';


$app = new \Slim\App(['settings'=>$config]);

//get container app
$container = $app->getContainer();
$container['db']=function($c)
{
    $db=$c['settings']['db'];
    $pdo=new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'],$db['user'],$db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/user', function(Request $request, Response $response){

    //get all user from database
    $stmt =$this->db->prepare("SELECT * FROM users" );
    $stmt->execute();

    //return users
    $result=$stmt->fetchAll();
    //response json
    return $this->response->withJson($result);
});

$app->get('/user/{id}',function(Request $request, Response $response, $args)
{
    //get id from args
    $id=(int)$args['id'];

    //prepare query filter id
    $stmt=$this->db->prepare("SELECT * FROM users WHERE idusers=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    //get user
    $result=$stmt->fetchAll();
    //retunrn json
    return $this->response->withJson($result);
});

$app->post('/user/add', function(Request $request, Response $response)
{
    // get data
    $data = $request->getParsedBody();

    //check data not empty
    if(!empty($data))
    {
        //get single values from array
        $email=$data['email'];
        $username=$data['username'];
        $passwd=md5($data['password']);
        //query
        $stmt=$this->db->prepare("INSERT INTO users(roles,email,passwd,username) VALUES(2,:email,:password,:username)");
        //parse params
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$passwd);
        $stmt->bindParam(':username',$username);
        $stmt->execute();

        //get last id insert
        $id = $this->db->lastInsertId();
        $stmt=$this->db->prepare("SELECT * FROM users WHERE idusers=:id");
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $result=$stmt->fetchAll();

        //if true user is insert
        if($result[0]['email']== $email)
        {
            return $this->response->withJson($data);
        }
        else
        {
            return $this->response->withJson(array('msg' => 'not add user'));
        }
    }

});

$app->put('/user/update/{id}',function(Request $request, Response $response, $args)
{
    //get id and parametters
    $id= $args['id'];
    $data = $request->getParsedBody();

    //get single values from array
    $username = $data['username'];
    $email = $data['email'];
    $passwd = md5($data['password']);
    //query
    $stmt = $this->db->prepare("UPDATE users SET email = :email, username = :username, passwd = :passwd WHERE idusers = :id");
    //parse values
    $stmt->bindParam(':id',$id);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':passwd',$passwd);
    $stmt->bindParam(':username',$username);
    $stmt->execute();

    //if true user is updated
    if($stmt->execute())
    {
        //return json
        return $this->response->withJson($data);
    }
    else
    {
        return $this->response->withJson(array('msg' => 'not update user'));
    }

});


$app->delete('/user/del/{id}', function(Request $request, Response $response, $args)
{
    //get id
    $id= $args['id'];
    //query
    $stmt=$this->db->prepare("DELETE FROM users WHERE idusers=:id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();

    if($stmt->execute())
    {
        return $this->response->withJson(array('msg' => 'delete user'));
    }
    else
    {
        return $this->response->withJson(array('msg' => 'user not deleted'));
    }
});
$app->run();