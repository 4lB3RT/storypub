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

        //get user for update variable session each refresh app in dashboard
        $this->refresh_user();
        if(empty(Session::get('user'))){
            Session::destroy();
            header("Location: /");
        }else{
            $user = Session::get('user');
        }

        if($user[0]["roles"] == "3" && $user[0]["valoracions"] >= 10){
            $this->upgrade_role();
        }
        //if session isn't started redirect to home
        if(!session::get('user')){
            header("Location: /");
            return;
        }

        //get all stories
        $only_stories = $this->model->get_stories();

        //new array
        $stories = Array();

        //get story and set valoration about story from current user
        foreach ($only_stories as $story){
            $val = $this->val_story($story["idstory"]);
            if(!empty($val)){
                $story["val"] = $val[0]["val"];
            }else{
                $story["val"] = 0;
            }
            array_push($stories,$story);
        }

        $data = array(
            'user' => $user,
            'stories' => $stories
        );

        //pass data to view
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

    function upgrade_role(){
        //get user
        $user = Session::get('user');

        //test user if empty
        if(empty($user)){
            return false;
        }

        //fill array with id
        $data = array(
            "id"      => $user[0]["idusers"]
        );

        //pass to model method data
        $this->model->role($data);
    }

    function val_story($id_story){

        //get user
        $user = Session::get('user');

        //test user if empty
        if(empty($user)){
            return false;
        }

        //fill array with id
        $data = array(
            "id"      => $user[0]["idusers"],
            "id_story"      => $id_story
        );

        //pass to model method data
        return $this->model->val_user($data);

    }

    function edit(){

        //get inputs from ajax
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $passwd = filter_input(INPUT_POST,'pass',FILTER_SANITIZE_ENCODED);
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_ENCODED);
        $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_ENCODED);

        //fill array
        $data = array(
            "email" => $email,
            "passwd" => $passwd,
            "username" => $username,
            "id" => $id
        );

        //pass inputs to model for add user
        $resul = $this->model->edit_user($data);

        if($resul){
            $user = array(0 => $data);
            Session::set('user',$user);
            $this->refresh_user();
            return $this->ajax(true);
        }

    }
}