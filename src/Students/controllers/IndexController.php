<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 06.08.2017
 * Time: 10:58
 */

namespace Students\Controllers;

use Framework\BaseController;
use Students\Models\Students;


class IndexController extends BaseController
{

    public function indexAction(){
    $model = new Students();


        $this->render('index',[
            'name' => '134'
        ]);
    }

    public function editAction($id){
        _d("id=$id for edit action");
    }

}