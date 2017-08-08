<?php

namespace Students\Models;
use Framework\ActiveRecord;
use Framework\Registry;


class Students extends ActiveRecord
{


public function __construct()
{
$registry = Registry::getInstance();
    parent::__construct('students', 'id', $registry['db'] );
}

}