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
public function __construct()
{
    $this->model = new Students();
    parent::__construct();

}

    public function indexAction(){

    $students = $this->model->findAll();
        $this->render('index',[
            'students' => $students
        ]);
    }

    public function editAction($id = null){
        //save, update action
        if($this->request->isPost()){
        _d($this->request->postData());
        }

        if($id){
            $student = $this->model->findById($id);
            if(!$student){
                throw new \Exception("No record found with given id= $id");
            }
            $this->render('edit', [
                    'student' => $student
                ]
            );
        }else{
            $this->render('create', [
                    'student' => $this->model
                ]
            );
        }

    }

    public function viewAction($id)
    {

        $student = $this->model->findById($id);
        if (!$student) {
            throw new \Exception("No record found with given id= $id");
        }
        $this->render('edit', [
                'student' => $student
            ]
        );
    }
    public function deleteAction($id){
        if($id) {
            _d("id=$id for delete action");
        }
        else _d('view action');
    }

}