<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 7/5/17
 * Time: 22:19
 */

namespace X\App\Controllers;


use X\Sys\Controller;
use X\Sys\Session;

class Story extends Controller
{
 function __construct($params = null, $dataView = null)
 {
     parent::__construct($params, $dataView);
     $this->addData(array('page' => 'Story'));
     $this->model = new \X\App\Models\mstory();
     $this->view = new \X\App\Views\vstory($this->dataView,$this->dataTable);
 }
    function home(){

        $this->refresh_user();
        if(empty(Session::get('user'))){
            Session::destroy();
            header("Location: /");
        }else{
            $user = Session::get('user');
        }

        if(!session::get('user')){
            header("Location: /");
            return;
        }
        $data = array(
            'user' => $user,
        );

        //pass data to view
        $this->addData($data);
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();

    }


    function refresh_user(){

        $user = Session::get('user');
        $email = $user[0]['email'];
        $pass = $user[0]['passwd'];

        //if is empty email or password redirect to login again
        if(empty($email) || empty($pass)){
            header("Location:/login");
        }

        //testing login
        $result = $this->model->reload_user($email,$pass);

        //if login is success create a variable session, else redirect to login again
        if($result){
            Session::set('user',$result);
            $this->ajax(true);
        }else{
            Session::del('user');
            header("Location: /login");
            $this->ajax(false);
        }
    }
}