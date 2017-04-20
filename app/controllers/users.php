<?php

namespace X\App\Controllers;

   use X\Sys\Controller;


   class Users extends Controller{
   		

   		public function __construct($params){
            parent::__construct($params);
            $this->addData(array(
               'page'=>'Users'));
            $this->model=new \X\App\Models\mUsers();
            $this->view =new \X\App\Views\vUsers($this->dataView);
            
         }
         
   		function home(){

         }

         function edit(){

   		    //get inputs from ajax
             $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
             $pass = filter_input(INPUT_POST,'pass',FILTER_SANITIZE_ENCODED);
             $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_ENCODED);
             $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_ENCODED);

             //fill array
             $data = array(
                 "email" => $email,
                 "pass" => $pass,
                 "username" => $username,
                 "id" => $id
             );

             //pass inputs to model for add user
             $resul = $this->model->edit_user($data);

             if($resul){
                 //change model for get login
                 $this->model = new \X\App\Models\mLogin();

                 //login
                 Login::login();
                 header("Location: /dashboard");
                 return $this->ajax(true);
             }

         }
   }