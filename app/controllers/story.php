<?php
/**
 * Created by PhpStorm.
 * User: Albert
 * Date: 7/5/17
 * Time: 22:19
 */

namespace X\App\Controllers;


use X\Sys\Controller;

class Story extends Controller
{
 function __construct($params = null, $dataView = null)
 {
     parent::__construct($params, $dataView);
     $this->addData(array('page' => 'Dashboard'));
     $this->model = new \X\App\Models\mdashboard();
     $this->view = new \X\App\Views\vdashboard($this->dataView,$this->dataTable);
 }
}