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

        $this->query("SELECT * FROM users WHERE email=:email AND passwd=:pass;");
        $this->bind(":email",$email);
        $this->bind(":pass",$pass);
        $resul = $this->execute();
        $resul = $this->resultset();

        if($resul>1){
            return $resul;
        }

        return false;
    }
}