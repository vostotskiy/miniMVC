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
use Framework\Flash;


class IndexController extends BaseController
{
    public function __construct()
    {
        $this->model = new Students();
        parent::__construct();

    }

    public function indexAction()
    {
        $students = $this->model->findAll();
        $this->render('index', [
            'students' => $students
        ]);
    }

    public function editAction($id = null)
    {
        //save, update actions
        if ($this->request->isPost()) {
            $fields = $this->request->postData();
            $errors = $this->model->validate($this->request->postData());
            if ($errors) {
                foreach ($errors as $error) {
                    $this->setFlash(Flash::FLASH_DANGER, $error);
                }
                 return $this->render('edit', [
                        'student' => $this->model->fill($fields)
                    ]
                );
            } else {
                if ($this->model->fill($fields)->save()) {
                    $this->setFlash(Flash::FLASH_SUCCESS, "Student's data has been succesfully saved");
                    $this->redirect('/');
                }
            }
        }

        if ($id) {
            $student = $this->model->findById($id);
            if (!$student) {
                throw new \Exception("No record found with given id= $id");
            }
            $this->render('edit', [
                    'student' => $student
                ]
            );
        } else {
            $this->render('edit', [
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
        $this->render('view', [
                'student' => $student
            ]
        );
    }

    public function deleteAction($id)
    {
        //@todo filter id
        if (!$id) {
            throw new \Exception("No record found with given id= $id");
        }
        $student = $this->model->findById($id);

        if ($student->delete()) {
            $this->setFlash(Flash::FLASH_SUCCESS, "Record  has been succesfully deleted");
            $this->redirect('/');
        }

    }

}