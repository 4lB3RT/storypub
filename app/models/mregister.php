<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/02/17
 * Time: 16:36
 */

namespace X\App\Models;


use X\Sys\Model;

class mRegister extends Model
{
    public function __construct(){
        parent::__construct();
    }

    public function insert_user($email,$pass,$username){

        $this->query("SELECT * FROM users WHERE email =:email;");
        $this->bind(":email",$email);
        $this->execute();
        $resul = $this->rowCount();
        if($resul < 1){
            $this->query("INSERT INTO users (roles,email,passwd,username) VALUES (3,:email,:pass,:username);");
            $this->bind(":email",$email);
            $this->bind(":pass",$pass);
            $this->bind(":username",$username);
            $this->execute();
            return true;
        }

        return false;
    }
}