<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/02/17
 * Time: 16:36
 */

namespace X\App\Models;


use X\Sys\Model;

class mLogin extends Model
{
    public function __construct(){
        parent::__construct();

    }

    function login($email,$pass){

        $this->query("SELECT * FROM users WHERE email=:email && password=:pass");
        $this->bind(":eamil",$email);
        $this->bind(":pass",$pass);
        $this->execute();
        $resul = $this->rowCount();

        if($resul>1){
            return true;
        }

        return false;
    }
}