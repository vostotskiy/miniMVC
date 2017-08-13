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
                    $isValid = false;
                    if(isset($props['v_regexp']) && ($props['validate']= FILTER_VALIDATE_REGEXP)){
                        $isValid = filter_var($params[$field], $props['validate'], array("options" => array("regexp" => $props['v_regexp'])));
                    } else{
                        $isValid = filter_var($params[$field],$props['validate']);
                    }
                    if(!$isValid ){
                        $errors[] = "Field $field is not valid";
                    }
                }
            }

        }
        return $errors;

    }
    //@todo add filter method to sanitize input

}