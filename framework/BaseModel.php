<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 19:19
 */

namespace Framework;


class BaseModel extends ActiveRecord
{
    protected $fields;

    public function validate($params){
        $errors = [];
        foreach ($this->fields as $field => $props){
            if($props['required']){
                if(!isset($params[$field])){
                    $errors[] = "Field $field is required";
                }else{

                    if(!filter_var($params[$field],$props['filter'])){
                        $errors[] = "Field $field is not valid";
                    }
                }
            }

        }
        return $errors;

    }

}