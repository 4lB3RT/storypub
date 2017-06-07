<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mstory extends Model{
		public function __construct(){
			parent::__construct();
			
		}

        function reload_user($email,$pass){
            $this->query("SELECT *  FROM users WHERE users.email=:email AND users.passwd=:pass;");
            $this->bind(":email",$email);
            $this->bind(":pass",$pass);
            $this->execute();
            $resul = $this->resultset();

            if($resul[0] > 1){
                $this->query("SELECT COUNT(val) as valoracions FROM valoracions  WHERE user = :user");
                $this->bind(":user",$resul[0]["idusers"]);
                $this->execute();
                $val = $this->resultset();
                $resul[0] = array_merge($resul[0],$val[0]);
                return $resul;
            }
        }
	}
