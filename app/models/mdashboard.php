<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 30/3/17
 * Time: 21:19
 */

namespace X\App\Models;


use X\Sys\Model;

class mdashboard extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_stories()
    {
        //get all stories with valorations
        $this->query("SELECT users.idusers,users.username, stories.idstory,title,history,date_in FROM stories 
                                                                  INNER JOIN users ON stories.user = users.idusers
                                                                  ORDER BY date_in DESC ;");
        $this->execute();
        $data = $this->resultset();
        return $data;
    }

    function set_add_story($data)
    {
        //query insert in table stories with date
        $this->query("INSERT INTO stories (title,history,user,date_in) VALUES (:title,:story,:iduser,:date_in)");
        $this->bind(":title", $data["title"]);
        $this->bind(":story", $data["story"]);
        $this->bind(":iduser", $data["user"]);
        $this->bind(":date_in", date("F j, Y, g:i a"));
        $this->execute();
    }

    function del_story($id)
    {
        $this->query("DELETE  FROM stories WHERE idstory = :id");
        $this->bind(":id", $id);
        $this->execute();
    }

    function get_story($data)
    {
        //get a single story
        $this->query("SELECT * FROM stories WHERE idstory = :id ;");
        $this->bind(":id", $data["id"]);
        $this->execute();
        $data = $this->resultset();
        return $data;
    }

    function set_edit_story($data)
    {
        //update story
        $this->query("UPDATE stories SET title =:title , history =:story, user =:iduser,date_in =:date_in WHERE idstory =:id ");
        $this->bind(":id", $data["id"]);
        $this->bind(":title", $data["title"]);
        $this->bind(":story", $data["history"]);
        $this->bind(":iduser", $data["user"]);
        $this->bind(":date_in", date("F j, Y, g:i a"));
        $this->execute();
    }

    function set_rate($data)
    {
        //check if have any rate from user about story
        $this->query("SELECT * FROM valoracions WHERE user =:id_user and story =:id_story ");
        $this->bind(":id_story", $data["id_story"]);
        $this->bind(":id_user", $data["id_user"]);
        $this->execute();
        $result = $this->rowCount();

        //if is true udpate else insert
        if($result > 0){
            $this->query("UPDATE valoracions SET val = :rate ,story = :id_story ,user =:id_user WHERE user = :id_user and story = :id_story");
            $this->bind(":id_story", $data["id_story"]);
            $this->bind(":id_user", $data["id_user"]);
            $this->bind(":rate", $data["rate"]);
            $res = $this->execute();

        }else{
            $this->query("INSERT INTO valoracions (val,story,user) VALUES(:rate,:id_story,:id_user)");
            $this->bind(":id_story", $data["id_story"]);
            $this->bind(":id_user", $data["id_user"]);
            $this->bind(":rate", $data["rate"]);
            $res = $this->execute();
        }


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

    function role($data){
        $this->query("UPDATE users SET roles = 2 WHERE idusers = :id_user");
        $this->bind(":id_user",$data["id"]);
        $this->execute();
    }

    function val_user($data){
        $this->query("SELECT val FROM valoracions WHERE user =:id_user && story =:id_story");
        $this->bind(":id_user",$data["id"]);
        $this->bind(":id_story",$data["id_story"]);
        $this->execute();
        $val = $this->resultset();
        return $val;
    }

    function edit_user($data){

        if($data["passwd"]){
            $this->query("UPDATE users SET username =:username , email =:email , passwd =:pass WHERE idusers =:id ");
            $this->bind(":id",$data["id"]);
            $this->bind(":email",$data["email"]);
            $this->bind(":pass",$data["passwd"]);
            $this->bind(":username",$data["username"]);
            $resul = $this->execute();
            return $resul;
        }

    }
}