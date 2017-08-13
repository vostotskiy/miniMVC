<?php

namespace Students\Models;

use Framework\BaseModel;


class Students extends BaseModel
{
    protected $table_name = 'students';

    protected $fields = [
        'id' => [
            'validate' => FILTER_VALIDATE_INT,
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'required' => false
        ],
        'first_name' => [
            'validate' => FILTER_DEFAULT,
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'last_name' => [
            'validate' => FILTER_DEFAULT,
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'email' => [
            'validate' => FILTER_VALIDATE_EMAIL,
            'filter' => FILTER_SANITIZE_EMAIL,
            'required' => true
        ],
        'sex' => [
            'validate' => FILTER_VALIDATE_REGEXP,
            'filter' => FILTER_SANITIZE_STRING,
            'v_regexp' => "/^(male|female)$/",
            'required' => true
        ],
        'group_name' => [
            'validate' => FILTER_DEFAULT,
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'faculty_name' => [
            'validate' => FILTER_DEFAULT,
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'date_of_birth' => [
            'validate' => FILTER_VALIDATE_REGEXP,
            'filter' => FILTER_SANITIZE_STRING,
            'v_regexp' => "/^([\d]{4}-[\d]{2}-[\d]{2})$/",
            'required' => true
        ],



    ];


}