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
            return;
        }
        //get all stories
        $data = array(
            'user' => Session::get('user'),
            'stories' => $this->model->get_stories()
            ) ;

        //pass to view data
        $this->addData($data);
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();
    }


    function add_history(){

        //take all inputs method post
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_ENCODED);
        $history = filter_input(INPUT_POST,'history',FILTER_SANITIZE_ENCODED);
        $tags = filter_input(INPUT_POST,'tags',FILTER_SANITIZE_ENCODED);

        //get id user
        $user = Session::get('user');
        $user = $user[0];

        //checking if are empty
        if(empty($title) || empty($history) ||empty($tags) ){
            header("Location: /");
            return;
        }

        //fill array
        $data = array(
            "title" => $title,
            "history" => $history,
            "tags" => $tags,
            "user" => $user["idusers"]
        );

        //go to model to insert
        $result = $this->model->set_add_history($data);

        //if not insert redirect to dashboard with message
        if(!$result){
            header("Location: /");
            $this->addData(array('msg' => 'Not add your history'));
            $this->view->__construct($this->dataView);
            return;
        }

    }

    function del_story(){

        //get array from ajax
        $idstories = $_REQUEST['data'];

        //checking if are empty
        if(empty($idstories)){
            header("Location: /");
            return;
        }

        //delete story
        foreach ($idstories as $story => $key){
            $this->model->del_story($key);
        }

        header("Location: /");

    }
}