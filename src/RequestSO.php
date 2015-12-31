<?php
namespace PaulJulio\SlimEcho;

/**
 * Class RequestSO
 * @package PaulJulio\SlimEcho
 * @see PaulJulio\SlimEcho\Request
 *
 * The Settings Object for the \PaulJulio\SlimEcho\Request class
 */
class RequestSO {

    private $httpRequest;

    public function isValid() {
        return (isset($this->httpRequest) && $this->httpRequest instanceof \Psr\Http\Message\StreamInterface);
    }

    public function setHttpRequest(\Psr\Http\Message\StreamInterface $request) {
        $this->httpRequest = $request;
    }

    public function getHttpRequest() {
        return $this->httpRequest;
    }
}
