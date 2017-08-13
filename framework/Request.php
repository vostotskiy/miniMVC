<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 20:36
 */

namespace Framework;


class Request
{
    const PARAM_REQUEST_METHOD = "REQUEST_METHOD";
    const PARAM_REQUEST_URL = "REQUEST_URI";
    const PARAM_REQUEST_HOST = "HTTP_HOST";

    const METHOD_POST = "POST";
    const METHOD_GET = "GET";
    const METHOD_DELETE = "DELETE";
    const METHOD_PUT = "PUT";
//request params
    private $params;
    private $host;
    private $url;
    protected $method;
    protected $_post;
    protected $_get;



    public function __construct() {
        $this->method = $_SERVER[self::PARAM_REQUEST_METHOD];
        $this->params = $_REQUEST;
        $this->host = $_SERVER[self::PARAM_REQUEST_HOST];
        $this->url = $_SERVER[self::PARAM_REQUEST_URL];
        $this->_post = $_POST;
        $this->_get = $_GET;

    }

    public function isPost(){
        return ($this->method === self::METHOD_POST);
    }
    public function postData(){
        return $this->_post;
    }

    public function isGet(){
        return ($this->method === self::METHOD_GET);
    }

    public function get($param ){
        return $this->getParam($this->_get,$param);

    }

    public function post($param)
    {
        return $this->getParam($this->_post,$param);
    }

    public function getUrl() {
        return $this->url;
    }

    public function getParam($source,$key) {
        if (!isset($source[$key])) {
            throw new \InvalidArgumentException("The request parameter with key '$key' is invalid.");
        }
        return $source[$key];
    }

    //@todo filter request param for safety

    //    public function setParam($key, $value) {
//        $this->params[$key] = $value;
//        return $this;

//    }

//    public function getParams() {
//        return $this->params;
//    }
}