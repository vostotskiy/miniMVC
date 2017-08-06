<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 06.08.2017
 * Time: 10:58
 */

namespace Students\Controllers;

use Framework\BaseController;


class IndexController extends BaseController
{

    public function indexAction(){
        die('index action of index ctrl');
    }

    public function editAction($id){
        _d("id=$id for edit action");
    }

}