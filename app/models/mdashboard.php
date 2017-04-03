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

    function get_stories(){

        $this->query("SELECT users.idusers,users.username,stories.idstory,title,history,date_in FROM stories 
                                                                  INNER JOIN users ON stories.user = users.idusers
                                                                  ORDER BY date_in DESC;");
        $this->execute();
        $data = $this->resultset();
        return $data;
    }
    function set_add_history($data){

        //query insert in table stories with date
        $this->query("INSERT INTO stories (title,history,user,date_in) VALUES (:title,:history,:iduser,:date_in);");
        $this->bind(":title",$data["title"]);
        $this->bind(":history",$data["history"]);
        $this->bind(":iduser",$data["user"]);
        $this->bind(":date_in",date("F j, Y, g:i a"));
        $this->execute();
    }

    function del_story($id){
        $this->query("DELETE  FROM stories WHERE idstory = :id");
        $this->bind(":id",$id);
        $this->execute();
    }
}