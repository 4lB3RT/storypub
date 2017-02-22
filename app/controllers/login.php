<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/02/17
 * Time: 16:35
 */

namespace X\App\Controllers;


use X\Sys\Controller;

class Login extends Controller
{
    public function __construct($params){
        parent::__construct($params);
        $this->addData(array(
            'page'=>'Login'));
        $this->model=new \X\App\Models\mLogin();
        $this->view =new \X\App\Views\vHome($this->dataView,$this->dataTable);
    }

}