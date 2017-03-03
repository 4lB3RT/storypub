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

    public function insert_user($email,$pass,$pass_confirm,$username){

        $this->query("SELECT COUNT email FROM users WHERE email =:email");
        $this->bind(":email",$email);
        $this->execute();
        $resul = $this->rowCount();
        if($resul < 1){
            $this->query("INSERT INTO users(email,pass,confirm_pass,username) VALUES(:email,:pass,:pass_confirm,:username");
            $this->bind(":email",$email);
            $this->bind(":pass",$pass);
            $this->bind(":pass_confirm",$pass_confirm);
            $this->bind(":username",$username);
            $this->execute();
            return true;
        }

        return false;
    }
}