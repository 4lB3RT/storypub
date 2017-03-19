<?php

namespace X\App\Controllers;

use X\Sys\Controller;

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
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();

    }
    function adduser(){
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $pass = filter_input(INPUT_POST,'pass',FILTER_SANITIZE_ENCODED);
        $pass_confirm = filter_input(INPUT_POST,'pass_confirm',FILTER_SANITIZE_ENCODED);
        $username = filter_input(INPUT_POST,'email',FILTER_SANITIZE_ENCODED);

        $resul = $this->model->insert_user($email,$pass,$pass_confirm,$username);

        if($resul){
            $this->ajax(array('msg'=>'Success'));
        }else{
            $this->ajax(array('msg'=>'Not Registry'));
        }

    }
}