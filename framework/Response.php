<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 20:36
 */

namespace Framework;


class Response
{
    protected $registry;
    protected $body;
    protected $headers;
    protected $statusCode;
    private static $httpCodes = [
        200 => "OK",
        304 => "Not Modified",
        403 => "Forbidden",
        404 => "Not Found"
    ];

    public function __construct($statusCode = 200, $headers = array(), $body = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
        $this->registry = Registry::getInstance();
    }

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    public function addHeader($header) {
        $this->headers[] = $header;
        return $this;
    }

    public function addHeaders(array $headers) {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }
        return $this;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function send()
    {
        header("HTTP/1.1 {$this->statusCode} " . self::$httpCodes[$this->statusCode]);
        foreach ($this->headers as $header => $value) {
            header(strtoupper($header).': '.$value);
        }
        echo $this->body;
    }

    public static function redirect($url){
        $registry = Registry::getInstance();

        if($registry->flashes) {
            $_SESSION['flashes'] = $registry->flashes;
        }
        header("Location: $url", 301);
        exit();
    }



}