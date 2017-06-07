<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 30/3/17
 * Time: 21:25
 */

namespace X\App\Views;


use X\Sys\View;

class vdashboard extends View
{
    public function __construct($dataView, $dataTable = null)
    {
        parent::__construct($dataView, $dataTable);
        $this->output = $this->render('tdashboard.php');
    }

}