<?php


namespace Common\Controllers;

use Framework\BaseController;

class IndexController extends BaseController
{
    public function indexAction(){

    }

    public function error404Action(){

        $this->render('error404',[]);
    }
}