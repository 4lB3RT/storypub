<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;
   use X\Sys\Session;


   class Home extends Controller{
   		

   		public function __construct($params){
   			parent::__construct($params);
            $this->addData(array(
               'page'=>'Home'));
   			$this->model=new \X\App\Models\mHome();
   			$this->view =new \X\App\Views\vHome($this->dataView,$this->dataTable);    
   		}


   		function home(){
          
            $data=$this->model->getRoles();
            $this->addData($data);
            //rebuilding with new data

            //if session is started redirect to dashboard
            if(Session::get('user')){
                header("Location: /dashboard");
            }
            $this->view->__construct($this->dataView,$this->dataTable);
            $this->view->show();
            
   		}

         
   }
