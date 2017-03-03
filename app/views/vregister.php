<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/02/17
 * Time: 18:39
 */

namespace X\App\Views;


use X\Sys\View;

class vRegister extends View
{
    function __construct($dataView,$dataTable=null){
        parent::__construct($dataView,$dataTable);
        $this->output= $this->render('tregister.php');

    }

}