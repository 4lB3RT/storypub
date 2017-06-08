<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 8/6/17
 * Time: 19:08
 */

    function getDB($dsn,$usr,$pwd)
    {
        try
        {
            $dbh=new PDO($dsn,$usr,$pwd);
        } catch (PDOException $ex) {
            return null;
        }
        return $dbh;
    }