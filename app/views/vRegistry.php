<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 20/02/17
 * Time: 16:36
 */

namespace X\App\Views;


use X\Sys\View;

class vLogin extends View
{
    function __construct($dataView,$dataTable=null){
        parent::__construct($dataView,$dataTable);
        $this->output= $this->render('tlogin.php');

    }

}