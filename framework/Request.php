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



    public function __construct() {
        $this->requestMethod = $_SERVER[self::PARAM_REQUEST_METHOD];
        $this->params = $_REQUEST;
        $this->host = $_SERVER[self::PARAM_REQUEST_HOST];
        $this->url = $_SERVER[self::PARAM_REQUEST_URL];
    }

    public function getUrl() {
        return $this->url;
    }

    public function setParam($key, $value) {
        $this->params[$key] = $value;
        return $this;
    }

    public function getParam($key) {
        if (!isset($this->params[$key])) {
            throw new \InvalidArgumentException("The request parameter with key '$key' is invalid.");
        }
        return $this->params[$key];
    }

    public function getParams() {
        return $this->params;
    }
}