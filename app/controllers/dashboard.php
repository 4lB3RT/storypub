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
            );

        //pass to view data
        $this->addData($data);
        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();
    }


    function save_story(){

        //get all inputs method post
        $id = filter_input(INPUT_POST,'id_story',FILTER_SANITIZE_ENCODED);
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_ENCODED);
        $story = filter_input(INPUT_POST,'history',FILTER_SANITIZE_ENCODED);
        $tags = filter_input(INPUT_POST,'tags',FILTER_SANITIZE_ENCODED);
        $image = APP_W.'pub/img/'.filter_input(INPUT_POST,'image',FILTER_SANITIZE_ENCODED);

        $img_ext = strtolower(pathinfo($image,PATHINFO_EXTENSION));

        //get id user
        $user = Session::get('user');
        $user = $user[0];

        //checking if are empty
        if(empty($title) || empty($story) ||empty($tags) ){
            header("Location: /");
            return;
        }

        if($id == null){

            //fill array
            $data = array(
                "title" => $title,
                "story" => $story,
                "tags" => $tags,
                "user" => $user["idusers"]
            );

            //go to model to insert
            $result = $this->model->set_add_story($data);

        }else{

            //fill array with id is a edit
            $data = array(
                "id" => $id,
                "title" => $title,
                "history" => $story,
                "tags" => $tags,
                "user" => $user["idusers"]
            );

            //go to model to insert
            $result = $this->model->set_edit_story($data);
        }


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

    function list_story(){

        //get id story from method ajax
        $id_story = $_REQUEST["id"];

        //transform to array
        $data = array(
            "id" => $id_story
        );

        //return story
        $story = $this->model->get_story($data);

        if($story){
            return $this->ajax($story);
        }

    }

    function rating(){

        //get id story from method ajax
        $rate = $_REQUEST["rate"];
        $id_story = $_REQUEST["id_stroy"];
        $id_user = $_REQUEST["id_user"];

        //transform to array
        $data = array(
            "rate"      => $rate,
            "id_story"  => $id_story,
            "id_user"   => $id_user
        );

        //return story
        $result = $this->model->set_rate($data);

        if($result){
            return $this->ajax($result);
        }

    }
}