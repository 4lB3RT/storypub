<?php

namespace X\App\Controllers;

use X\Sys\Controller;
use X\Sys\Session;

class Register extends Controller{

    public function __construct($params){
    parent::__construct($params);
    $this->addData(array(
        'page'=>'Register'));
    $this->model=new \X\App\Models\mRegister();
    $this->view =new \X\App\Views\vRegister($this->dataView,$this->dataTable);

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
    function adduser(){
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $pass = filter_input(INPUT_POST,'pass',FILTER_SANITIZE_ENCODED);
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_ENCODED);
        $roles = filter_input(INPUT_POST,'roles',FILTER_SANITIZE_ENCODED);

        $resul = $this->model->insert_user($email,$pass,$roles,$username);

        if($resul){
            $this->model = new \X\App\Models\mLogin();
            Login::login();
            header("Location: /dashboard");
        }else{
            $this->ajax(array('msg'=>'Not Registry'));
        }

    }
}