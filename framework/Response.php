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
    public function __construct() {

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

    public function send() {
        if (!headers_sent()) {
            foreach($this->headers as $header) {
                header("$this->version $header", true);
            }
        }
    }
}