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

        $this->query("SELECT *  FROM users WHERE users.email=:email AND users.passwd=:pass;");
        $this->bind(":email",$email);
        $this->bind(":pass",$pass);
        $resul = $this->execute();
        $resul = $this->resultset();

        if($resul[0] > 1){
            $this->query("SELECT COUNT(val) as valoration FROM valoracions  WHERE user = :user");
            $this->bind(":user",$resul[0]["idusers"]);
            $test = $this->execute();
            $val = $this->resultset();
            $resul[0] = array_merge($resul[0],$val[0]);
            return $resul;
        }

        return false;
    }
}