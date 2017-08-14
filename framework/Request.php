<?php

namespace Framework;


/**
 * Class Request
 * @package Framework
 */
class Request
{
    //$_REQUEST array field's keys
    const PARAM_REQUEST_METHOD = "REQUEST_METHOD";
    const PARAM_REQUEST_URL = "REQUEST_URI";
    const PARAM_REQUEST_HOST = "HTTP_HOST";

    //request method's names
    const METHOD_POST = "POST";
    const METHOD_GET = "GET";
    const METHOD_DELETE = "DELETE";
    const METHOD_PUT = "PUT";


    /** registry instance
     * @var Registry|null
     */
    private $registry;
    //request params

    /**request params
     * @var array
     */
    private $params;
    /**application host url
     * @var
     */
    private $host;
    /**request url
     * @var
     */
    private $url;
    /**request method
     * @var
     */
    protected $method;
    /**$_POST values
     * @var
     */
    protected $_post;
    /**$_GET array values
     * @var
     */
    protected $_get;


    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->method = $_SERVER[self::PARAM_REQUEST_METHOD];
        $this->params = $_REQUEST;
        $this->host = $_SERVER[self::PARAM_REQUEST_HOST];
        $this->url = $_SERVER[self::PARAM_REQUEST_URL];
        $this->_post = $_POST;
        $this->_get = $_GET;
        $this->registry = Registry::getInstance();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->registry->flashes = [];
        if (isset($_SESSION['flashes'])) {
            $this->registry->flashes = $_SESSION['flashes'];
            unset ($_SESSION['flashes']);
        }

    }

    /**check whether current method is POST
     * @return bool
     */
    public function isPost()
    {
        return ($this->method === self::METHOD_POST);
    }

    /**return $_POST fields
     * @return mixed
     */
    public function postData()
    {
        return $this->_post;
    }

    /**checks whether current method is GET
     * @return bool
     */
    public function isGet()
    {
        return ($this->method === self::METHOD_GET);
    }

    /**return $_GET fields
     * @param $param
     * @return mixed
     */
    public function get($param)
    {
        return $this->getParam($this->_get, $param);

    }

    /**get value from $_POST array by key
     * @param $param
     * @return mixed
     */
    public function post($param)
    {
        return $this->getParam($this->_post, $param);
    }

    /** return request url
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /** get param from $_GET or $_POST arrays
     * @param $source array $_GET or $_POST arrays, stored in $_get and $_post variables
     * @param $key field name
     * @return mixed proper array field value
     */
    public function getParam($source, $key)
    {
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