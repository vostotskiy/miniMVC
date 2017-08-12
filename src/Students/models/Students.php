<?php

namespace Students\Models;

use Framework\BaseModel;


class Students extends BaseModel
{
    protected $table_name = 'students';

    protected $fields = [
        'id' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'required' => false
        ],
        'first_name' => [
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'last_name' => [
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'email' => [
            'filter' => FILTER_SANITIZE_EMAIL,
            'required' => true
        ],
        'sex' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'regexp' => "/^(male|female)$/",
            'required' => true
        ],
        'group' => [
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'faculty' => [
            'filter' => FILTER_SANITIZE_STRING,
            'required' => true
        ],
        'date_of_birth' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'regexp' => "/^([\d]{4}-[\d]{2}-[\d]{2})$/",
            'required' => true
        ],



    ];


}