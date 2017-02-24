<?php

namespace X\App\Controllers;

use \X\App\Controllers;

class Registry extends Controllers{

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
}