<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mUsers extends Model{
		public function __construct(){
			parent::__construct();
			
		}

		function edit_user($data){

            if($data["pass"]){
                $this->query("UPDATE users SET username =:username , email =:email , passwd =:pass WHERE idusers =:id ");
                $this->bind(":id",$data["id"]);
                $this->bind(":email",$data["email"]);
                $this->bind(":pass",$data["pass"]);
                $this->bind(":username",$data["username"]);
                $resul = $this->execute();
                return $resul;
            }

        }
	}