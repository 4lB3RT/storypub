<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 30/3/17
 * Time: 21:20
 */

namespace X\App\Controllers;


use X\App\Models\mdashboard;
use X\Sys\Controller;
use X\Sys\Session;

class dashboard extends Controller
{

    function __construct($params)
    {
        parent::__construct($params);
        $this->addData(array('page' => 'Dashboard'));
        $this->model = new \X\App\Models\mdashboard();
        $this->view = new \X\App\Views\vdashboard($this->dataView,$this->dataTable);
    }

    function home(){

        //if session isn't started redirect to home
        if(!session::get('user')){
            header("Location: /");
        }
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();
    }

    function add_history(){
        $p1 =1;
    }
}