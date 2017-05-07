<?php

namespace X\App\Controllers;

   use X\Sys\Controller;
    use X\Sys\Session;

   class Users extends Controller{
   		

   		public function __construct($params){
            parent::__construct($params);
            $this->addData(array(
               'page'=>'Users'));
            $this->model=new \X\App\Models\mUsers();
            $this->view =new \X\App\Views\vUsers($this->dataView);
            
         }
         
   		function home(){

            //if session is started redirect to dashboard
            if(Session::get('user')){
                header("Location: /dashboard");
            }
            $this->view->__construct($this->dataView,$this->dataTable);
            $this->view->show();
         }


   }