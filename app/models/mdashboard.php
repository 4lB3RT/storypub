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

    function get_stories($user)
    {
        $this->query("SELECT COUNT(val) as valoration FROM users INNER JOIN valoracions ON users.idusers = valoracions.user");
        $this->execute();
        $resul = $this->resultset();

        if($resul[0] > 10){
            $this->query("UPDATE users SET roles = 2 WHERE idusers =:user");
            $this->bind(":user", $user["idusers"]);
            $this->execute();
        }

        $this->query("SELECT users.idusers,users.username, valoracions.val, stories.idstory,title,history,date_in FROM valoracions 
                                                                  RIGHT JOIN stories ON valoracions.story = stories.idstory
                                                                  INNER JOIN users ON stories.user = users.idusers
                                                                  ORDER BY date_in DESC;");
        $this->execute();
        $data = $this->resultset();
        return $data;
    }

    function set_add_story($data)
    {

        //query insert in table stories with date
        $this->query("INSERT INTO stories (title,history,user,date_in) VALUES (:title,:story,:iduser,:date_in);");
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

        $this->query("SELECT * FROM stories WHERE idstory = :id ;");
        $this->bind(":id", $data["id"]);
        $this->execute();
        $data = $this->resultset();
        return $data;
    }

    function set_edit_story($data)
    {

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
}