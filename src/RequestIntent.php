<?php
namespace PaulJulio\SlimEcho;

/**
 * Class RequestIntent
 * @package PaulJulio\SlimEcho
 */
class RequestIntent extends Request {

    /**
     * @return string
     */
    public function getName() {
        return $this->httpRequest->request->intent->name;
    }

    /**
     * @return array
     *
     * converts the stdClass for the Slots into an array
     */
    public function getSlots() {
        return json_decode(json_encode($this->httpRequest->request->intent->slots),true);
    }
}