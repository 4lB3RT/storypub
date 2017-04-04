<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/02/17
 * Time: 16:35
 */

namespace X\App\Controllers;


use X\Sys\Controller;
use X\Sys\Session;

class Login extends Controller
{
    public function __construct($params){
        parent::__construct($params);
        $this->addData(array(
            'page'=>'Login'));
        $this->model=new \X\App\Models\mLogin();
        $this->view =new \X\App\Views\vLogin($this->dataView,$this->dataTable);
    }

    function home(){

        //$data=$this->model->getRoles();
        //$this->addData($data);
        //rebuilding with new data
        //if session is started redirect to dashboard
        if(Session::get('user')){
            header("Location: /dashboard");
        }
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();

    }

    function login(){

        $email = $_REQUEST['email'];
        $pass = $_REQUEST['pass'];

        //if is empty email or password redirect to login again
        if(empty($email) || empty($pass)){
            header("Location:/login");
        }

        //testing login
        $result = $this->model->login($email,$pass);

        if($result){
            Session::set('user',$result);
            $this->ajax(true);
        }else{
            header("Location: /login");
            $this->ajax(false);
        }
    }

    function disconnect(){

        Session::del('user');
        header("Location: /");

    }
}