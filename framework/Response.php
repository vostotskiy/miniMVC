<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 20:36
 */

namespace Framework;


/**
 * Class Response aimed to provide application response with headers and content
 * @package Framework
 */
class Response
{
    /** registry instance
     * @var Registry|null
     */
    protected $registry;
    /**content of response
     * @var null
     */
    protected $body;
    /**array of headers
     * @var array
     */
    protected $headers;
    /**response status
     * @var int
     */
    protected $statusCode;
    /**headers codes messages
     * @var array
     */
    private static $httpCodes = [
        200 => "OK",
        304 => "Not Modified",
        403 => "Forbidden",
        404 => "Not Found"
    ];

    /**
     * Response constructor.
     * @param int $statusCode
     * @param array $headers
     * @param null $body
     */
    public function __construct($statusCode = 200, $headers = array(), $body = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
        $this->registry = Registry::getInstance();
    }

    /** get current code of response status
     * @param $code
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /** set header for the array of headers
     * @param $header
     * @param $value
     * @return $this
     */
    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    /**set response content
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /** adds header to the array of headers
     * @param $header
     * @return Response $this
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    /** sets array of headers for response
     * @param array $headers response headers
     * @return  Response $this
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
        return $this;
    }

    /**get array of response headers
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *send application's response  with configured headers, and response content
     */
    public function send()
    {
        header("HTTP/1.1 {$this->statusCode} " . self::$httpCodes[$this->statusCode]);
        foreach ($this->headers as $header => $value) {
            header(strtoupper($header) . ': ' . $value);
        }
        echo $this->body;
    }

    /**redirects to given url by sending 301 headers with empty content
     * @param $url
     */
    public static function redirect($url)
    {
        $registry = Registry::getInstance();
        if ($registry->flashes) {
            $_SESSION['flashes'] = $registry->flashes;
        }
        header("Location: $url", 301);
        exit();
    }


}