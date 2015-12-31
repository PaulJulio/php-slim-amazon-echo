<?php
namespace PaulJulio\SlimEcho;

/**
 * Class RequestSessionEnded
 * @package PaulJulio\SlimEcho
 */
class RequestSessionEnded extends Request {

    public function getReason() {
        return $this->httpRequest->request->reason;
    }

}