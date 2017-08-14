<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 12.08.2017
 * Time: 19:19
 */

namespace Framework;


/**
 * Class BaseModel contains active record methods to operate with table
 * and domain data(fields, their properties, validate and sanitize methods)
 * @package Framework
 */
class BaseModel extends ActiveRecord
{
    /** list of domain fields with validation and sanitize options, required flags
     * @var
     */
    protected $fields;

    /** basic validation method for checking POST data before fill it to model instance
     * uses defined in $field array filters to check POST data to be valid
     * @param $params POST or other source variables for proper table fields
     * @return string[] validation error messages
     */
    public function validate($params)
    {
        $errors = [];
        foreach ($this->fields as $field => $props) {
            if ($props['required']) {
                if (!isset($params[$field])) {
                    $errors[] = "Field $field is required";
                } else {
                    $isValid = false;
                    if (isset($props['v_regexp']) && ($props['validate'] = FILTER_VALIDATE_REGEXP)) {
                        $isValid = filter_var($params[$field], $props['validate'], array("options" => array("regexp" => $props['v_regexp'])));
                    } else {
                        $isValid = filter_var($params[$field], $props['validate']);
                    }
                    if (!$isValid) {
                        $errors[] = "Field $field is not valid";
                    }
                }
            }

        }
        return $errors;

    }
    //@todo add filter method to sanitize input

}