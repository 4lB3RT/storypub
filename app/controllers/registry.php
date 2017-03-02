<?php

namespace X\App\Controllers;

use X\Sys\Controller;

class Registry extends Controller{

    public function __construct($params){
    parent::__construct($params);
    $this->addData(array(
        'page'=>'Registry'));
    $this->model=new \X\App\Models\mRegistry();
    $this->view =new \X\App\Views\vRegistry($this->dataView,$this->dataTable);
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
        $username = filter_input(INPUT_POST,'email',FILTER_SANITIZE_ENCODED);
    }
}